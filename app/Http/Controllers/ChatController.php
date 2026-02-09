<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\AIAssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected AIAssistantService $aiService;

    public function __construct(AIAssistantService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Send message to AI assistant
     */
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
            ]);

            // Get or create session ID
            $sessionId = $request->session()->get('chat_session_id', Str::uuid()->toString());
            $request->session()->put('chat_session_id', $sessionId);

            // Build context
            $context = [
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
            ];

            if ($request->has('latitude') && $request->has('longitude')) {
                $context['latitude'] = $request->latitude;
                $context['longitude'] = $request->longitude;
            }

            // Save user message
            $userMessage = $this->aiService->saveMessage([
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
                'role' => 'user',
                'message' => $request->message,
                'latitude' => $context['latitude'] ?? null,
                'longitude' => $context['longitude'] ?? null,
                'context' => $context,
            ]);

            // Get AI response
            $aiResponse = $this->aiService->chat($request->message, $context);

            // Save AI message
            $assistantMessage = $this->aiService->saveMessage([
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
                'role' => 'assistant',
                'message' => $aiResponse['message'],
                'intent' => $aiResponse['intent'],
                'suggested_events' => $aiResponse['suggested_events'],
                'context' => $context,
            ]);

            return response()->json([
                'success' => true,
                'message' => $aiResponse['message'],
                'intent' => $aiResponse['intent'],
                'events' => $aiResponse['events']->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'name' => $event->name,
                        'date' => $event->date->format('M d, Y'),
                        'time' => $event->date->format('g:i A'),
                        'venue' => $event->venue ? $event->venue->name : 'Online',
                        'price' => $event->price ? '$' . number_format($event->price, 2) : 'Free',
                        'image' => $event->image ? asset('storage/' . $event->image) : null,
                        'url' => route('events.show', $event->id),
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            \Log::error('Chat Controller Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error processing your message. Please try again or contact support if the issue persists.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred',
            ], 500);
        }
    }

    /**
     * Get chat history
     */
    public function getHistory(Request $request)
    {
        $sessionId = $request->session()->get('chat_session_id');
        
        if (!$sessionId) {
            return response()->json([
                'success' => true,
                'messages' => [],
            ]);
        }

        $messages = $this->aiService->getHistory($sessionId);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($msg) {
                return [
                    'role' => $msg->role,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at->diffForHumans(),
                    'events' => $msg->events()->get()->map(function ($event) {
                        return [
                            'id' => $event->id,
                            'name' => $event->name,
                            'date' => $event->date->format('M d, Y'),
                            'venue' => $event->venue ? $event->venue->name : 'Online',
                            'url' => route('events.show', $event->id),
                        ];
                    }),
                ];
            }),
        ]);
    }

    /**
     * Clear chat history
     */
    public function clearHistory(Request $request)
    {
        $sessionId = $request->session()->get('chat_session_id');
        
        if ($sessionId) {
            ChatMessage::where('session_id', $sessionId)->delete();
        }

        $request->session()->forget('chat_session_id');

        return response()->json([
            'success' => true,
            'message' => 'Chat history cleared',
        ]);
    }
}
