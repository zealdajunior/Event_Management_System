<?php

namespace App\Services;

use App\Models\Event;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AIAssistantService
{
    protected string $apiKey;
    protected string $model;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = 'gemini-2.5-flash';
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/' . $this->model . ':generateContent?key=' . $this->apiKey;
    }

    /**
     * Process user message and generate AI response
     */
    public function chat(string $message, array $context = []): array
    {
        // Detect user intent
        $intent = $this->detectIntent($message);
        
        // Get relevant events based on context
        $relevantEvents = $this->getRelevantEvents($message, $context);
        
        // If no API key, use fallback immediately
        if (empty($this->apiKey) || $this->apiKey === 'your-gemini-api-key-here') {
            return [
                'message' => $this->getFallbackResponse($message, $context, $relevantEvents),
                'intent' => $intent,
                'suggested_events' => $relevantEvents->pluck('id')->toArray(),
                'events' => $relevantEvents,
            ];
        }

        try {
            // Build conversation context
            $systemPrompt = $this->buildSystemPrompt($relevantEvents, $context);
            
            // Call Gemini API
            $response = Http::timeout(30)->post($this->apiUrl, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nUser: " . $message]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.9,
                    'maxOutputTokens' => 800,
                    'topP' => 1,
                ]
            ]);

            if ($response->failed()) {
                $status = $response->status();
                $errorMessage = 'AI API request failed: ' . $status;
                
                // Special handling for rate limit (429)
                if ($status === 429) {
                    $errorMessage = 'Rate limit exceeded - using fallback response';
                    Log::warning('Gemini API Rate Limited', [
                        'message' => 'Free tier has strict limits (15 req/min, 1500/day)',
                        'fallback' => 'Using direct event listing',
                    ]);
                } else {
                    Log::error('Gemini API Failed', [
                        'status' => $status,
                        'body' => $response->body(),
                        'url' => $this->apiUrl,
                    ]);
                }
                
                throw new \Exception($errorMessage);
            }

            $data = $response->json();
            
            // Log successful response structure for debugging
            Log::info('Gemini API Success', [
                'has_candidates' => isset($data['candidates']),
                'response_keys' => array_keys($data),
            ]);
            
            $aiMessage = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not process your request.';

            return [
                'message' => $aiMessage,
                'intent' => $intent,
                'suggested_events' => $relevantEvents->pluck('id')->toArray(),
                'events' => $relevantEvents,
            ];

        } catch (\Exception $e) {
            $isRateLimited = strpos($e->getMessage(), '429') !== false || strpos($e->getMessage(), 'Rate limit') !== false;
            
            Log::error('AI Assistant Error', [
                'error' => $e->getMessage(),
                'user_message' => $message,
                'is_rate_limited' => $isRateLimited,
            ]);

            // Fallback response - make it dynamic and conversational
            return [
                'message' => $this->getDynamicFallbackResponse($message, $context, $relevantEvents, $intent, $isRateLimited),
                'intent' => $intent,
                'suggested_events' => $relevantEvents->pluck('id')->toArray(),
                'events' => $relevantEvents,
            ];
        }
    }

    /**
     * Detect user intent from message
     */
    protected function detectIntent(string $message): string
    {
        $message = strtolower($message);

        // Greetings (highest priority)
        if (preg_match('/^(hi|hello|hey|good morning|good afternoon|good evening|greetings|howdy|sup|yo)\b/', $message)) {
            return 'greeting';
        }
        
        // Personal questions about the AI
        if (preg_match('/\b(who are you|what are you|your name|about you|what can you do|introduce yourself)\b/', $message)) {
            return 'about_assistant';
        }
        
        // How are you / small talk
        if (preg_match('/\b(how are you|how\'?s it going|what\'?s up|wassup|how do you do)\b/', $message)) {
            return 'smalltalk';
        }
        
        // Thank you
        if (preg_match('/\b(thanks|thank you|appreciate|thx|ty)\b/', $message)) {
            return 'thanks';
        }
        
        // Goodbye
        if (preg_match('/\b(bye|goodbye|see you|later|farewell|cya)\b/', $message)) {
            return 'goodbye';
        }
        
        // Location-based queries
        if (preg_match('/\b(near me|nearby|close|around|local|location|where|here)\b/', $message)) {
            return 'location_search';
        }
        
        // Date/time queries
        if (preg_match('/\b(today|tonight|tomorrow|weekend|week|month|date|when|schedule|upcoming|this|next)\b/', $message)) {
            return 'datetime_query';
        }
        
        // Category/type searches
        if (preg_match('/\b(music|concert|sports|festival|conference|workshop|comedy|theater|art|food|tech|business|party|wedding|networking)\b/', $message)) {
            return 'search';
        }
        
        // Booking intent
        if (preg_match('/\b(book|ticket|buy|purchase|register|attend|join|sign up|rsvp)\b/', $message)) {
            return 'booking';
        }
        
        // Pricing queries
        if (preg_match('/\b(price|cost|how much|fee|cheap|expensive|free|budget|under|affordable)\b/', $message)) {
            return 'pricing';
        }
        
        // General search
        if (preg_match('/\b(find|search|looking for|show me|events?|what\'?s on|happening|any|get|tell me)\b/', $message)) {
            return 'search';
        }
        
        // Help queries
        if (preg_match('/\b(help|how|explain|guide|can you|what do)\b/', $message)) {
            return 'help';
        }

        return 'general';
    }

    /**
     * Get relevant events based on message and context
     */
    protected function getRelevantEvents(string $message, array $context = [])
    {
        $query = Event::where('approval_status', 'approved')
            ->where('status', 'active')
            ->where('date', '>=', now());

        // Location-based filtering
        if (isset($context['latitude']) && isset($context['longitude'])) {
            $lat = $context['latitude'];
            $lon = $context['longitude'];
            $radius = $context['radius'] ?? 50; // km

            // Haversine formula for distance calculation
            $query->whereHas('venue', function ($q) use ($lat, $lon, $radius) {
                $q->whereRaw(
                    "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                    [$lat, $lon, $lat, $radius]
                );
            });
        }

        // Keyword search
        $keywords = $this->extractKeywords($message);
        $hasKeywords = !empty($keywords);
        
        // Check if this is a general "show me events" query without specific keywords
        $isGeneralQuery = preg_match('/\b(available|all events?|any events?|what events?|which events?|database|have|list|show)\b/i', $message);
        
        // Only filter by keywords if we have them AND it's not a general query
        if ($hasKeywords && !$isGeneralQuery) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%")
                      ->orWhereHas('category', function ($q) use ($keyword) {
                          $q->where('name', 'like', "%{$keyword}%");
                      });
                }
            });
        }

        // Date filtering
        if (preg_match('/\b(today|tonight)\b/i', $message)) {
            $query->whereDate('date', today());
        } elseif (preg_match('/\b(tomorrow)\b/i', $message)) {
            $query->whereDate('date', today()->addDay());
        } elseif (preg_match('/\b(this week|weekend)\b/i', $message)) {
            $query->whereBetween('date', [now(), now()->endOfWeek()]);
        } elseif (preg_match('/\b(next week)\b/i', $message)) {
            $query->whereBetween('date', [now()->startOfWeek()->addWeek(), now()->endOfWeek()->addWeek()]);
        } elseif (preg_match('/\b(upcoming|soon)\b/i', $message)) {
            // Show events in next 30 days
            $query->whereBetween('date', [now(), now()->addDays(30)]);
        }

        // Log query before execution for debugging
        Log::info('Event Search Query Build', [
            'message' => $message,
            'keywords' => $keywords,
            'is_general_query' => $isGeneralQuery ?? false,
            'has_keywords' => $hasKeywords ?? false,
            'keyword_filter_applied' => ($hasKeywords && !($isGeneralQuery ?? false)),
            'has_location_context' => isset($context['latitude']),
        ]);
        
        $events = $query->with(['venue', 'category'])
            ->orderBy('date', 'asc')
            ->limit(10)
            ->get();
            
        // Log for debugging
        Log::info('Event Search Results', [
            'events_found' => $events->count(),
            'event_names' => $events->pluck('name')->toArray(),
        ]);

        return $events;
    }

    /**
     * Extract keywords from message
     */
    protected function extractKeywords(string $message): array
    {
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'is', 'are', 'was', 'were', 'be', 'been', 'being',
                      'what', 'when', 'where', 'how', 'why', 'show', 'me', 'find', 'near', 'tell', 'can', 'you', 'get', 'any',
                      'some', 'this', 'that', 'with', 'have', 'has', 'had', 'will', 'would', 'could', 'should', 'there', 'their'];
        
        // Event categories and important keywords to prioritize
        $priorityKeywords = ['music', 'concert', 'sports', 'festival', 'conference', 'workshop', 'comedy', 'theater', 'theatre',
                             'art', 'food', 'tech', 'business', 'party', 'wedding', 'networking', 'seminar', 'exhibition',
                             'gaming', 'fitness', 'yoga', 'dance', 'film', 'movie', 'charity', 'cultural', 'outdoor'];
        
        $message = strtolower($message);
        $words = preg_split('/\s+/', $message);
        
        $keywords = [];
        foreach ($words as $word) {
            $word = preg_replace('/[^a-z0-9]/', '', $word);
            if (strlen($word) > 2 && !in_array($word, $stopWords)) {
                $keywords[] = $word;
            }
            // Add priority keywords even if short
            if (in_array($word, $priorityKeywords)) {
                $keywords[] = $word;
            }
        }

        return array_unique($keywords);
    }

    /**
     * Build system prompt with context
     */
    protected function buildSystemPrompt($events, array $context): string
    {
        $eventsList = '';
        $eventsCount = $events->count();
        
        if ($events->isNotEmpty()) {
            $eventsList = "\n\n=== AVAILABLE EVENTS IN DATABASE (MUST USE THESE ONLY) ===\n";
            $eventsList .= "Total events found: {$eventsCount}\n\n";
            
            foreach ($events as $index => $event) {
                $num = $index + 1;
                $venueName = $event->venue ? $event->venue->name : 'Online Event';
                $price = $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free';
                $category = $event->category ? $event->category->name : 'General';
                $description = $event->description ? substr($event->description, 0, 100) . '...' : 'No description';
                
                $eventsList .= "{$num}. EVENT NAME: {$event->name}\n";
                $eventsList .= "   - Date: {$event->date->format('l, F d, Y')}\n";
                $eventsList .= "   - Time: {$event->date->format('g:i A')}\n";
                $eventsList .= "   - Venue: {$venueName}\n";
                $eventsList .= "   - Price: {$price}\n";
                $eventsList .= "   - Category: {$category}\n";
                $eventsList .= "   - Description: {$description}\n";
                $eventsList .= "   - Event ID: {$event->id}\n\n";
            }
        } else {
            $eventsList = "\n\n=== NO EVENTS FOUND IN DATABASE ===\n";
            $eventsList .= "There are currently no events matching the user's query in our database.\n";
        }

        $locationContext = '';
        if (isset($context['latitude']) && isset($context['longitude'])) {
            $locationContext = "\n\nUser's Location: Latitude {$context['latitude']}, Longitude {$context['longitude']}";
        }

        return "You are Event Buddy, an intelligent AI assistant for an event management platform.

🎯 CRITICAL INSTRUCTIONS:
1. ONLY mention and discuss events that are listed in the 'AVAILABLE EVENTS IN DATABASE' section below
2. DO NOT make up or suggest events that are not in the database
3. If no events are found, clearly tell the user no events match their criteria
4. Always use specific event names, dates, times, and prices from the database
5. Format your responses with proper markdown for readability
6. Use emojis appropriately to make responses engaging
7. Be conversational but professional

📋 YOUR CAPABILITIES:
- Help users discover events from our database
- Provide detailed information about specific events
- Answer questions about booking, pricing, and venues
- Have friendly conversations and answer questions about yourself
- Suggest events based on user preferences (using only database events)

📅 CURRENT DATE: " . now()->format('l, F d, Y') . "
{$locationContext}
{$eventsList}

💬 RESPONSE FORMAT:
- Use markdown formatting (**, *, ###, bullet points, etc.)
- Structure responses with clear sections
- Use emojis for visual appeal
- Keep responses concise but informative (under 200 words)
- If showing events, format them nicely with all key details
- Always be friendly and helpful

⚠️ REMEMBER: Only discuss events from the database list above. If the list is empty, inform the user no events are available.";
    }

    /**
     * Dynamic fallback response that feels more human and conversational
     */
    protected function getDynamicFallbackResponse(string $message, array $context, $events, string $intent, bool $isRateLimited = false): string
    {
        $messageLower = strtolower($message);
        
        // If events found, always show them with dynamic commentary
        if ($events->isNotEmpty()) {
            $count = $events->count();
            $contextualIntros = [];
            
            // Generate contextual intro based on query
            if (stripos($message, 'available') !== false || stripos($message, 'have') !== false) {
                $contextualIntros[] = "Absolutely! We have {$count} exciting event" . ($count > 1 ? 's' : '') . " lined up for you! 🎉";
                $contextualIntros[] = "Great question! I found {$count} awesome event" . ($count > 1 ? 's' : '') . " in our system! ✨";
                $contextualIntros[] = "Yes! We've got {$count} amazing event" . ($count > 1 ? 's' : '') . " ready for you! 🎊";
            } elseif (stripos($message, 'music') !== false || stripos($message, 'concert') !== false) {
                $contextualIntros[] = "🎵 Music lover? Perfect! Here are {$count} event" . ($count > 1 ? 's' : '') . " that might interest you:";
                $contextualIntros[] = "🎸 I love a good music question! Check out these {$count} event" . ($count > 1 ? 's' : '') . ":";
            } elseif (stripos($message, 'weekend') !== false) {
                $contextualIntros[] = "🗓️ Weekend plans sorted! Here are {$count} event" . ($count > 1 ? 's' : '') . " happening:";
                $contextualIntros[] = "Perfect timing! I found {$count} event" . ($count > 1 ? 's' : '') . " for the weekend:";
            } elseif (stripos($message, 'free') !== false || stripos($message, 'cheap') !== false) {
                $contextualIntros[] = "💰 Budget-friendly options coming right up! Found {$count} event" . ($count > 1 ? 's' : '') . ":";
                $contextualIntros[] = "Great value alert! 💵 Here are {$count} event" . ($count > 1 ? 's' : '') . " for you:";
            } else {
                $contextualIntros[] = "Perfect! I found {$count} event" . ($count > 1 ? 's' : '') . " that might interest you! 🎯";
                $contextualIntros[] = "Here we go! {$count} exciting event" . ($count > 1 ? 's' : '') . " for you to explore! ✨";
                $contextualIntros[] = "Awesome! Let me show you {$count} great event" . ($count > 1 ? 's' : '') . "! 🌟";
            }
            
            $response = $contextualIntros[array_rand($contextualIntros)] . "\n\n";
            
            // Show first 5 events with rich details
            foreach ($events->take(5) as $index => $event) {
                $num = $index + 1;
                $price = $event->price > 0 ? '$' . number_format($event->price, 2) : '**FREE**';
                $venueName = $event->venue ? $event->venue->name : 'Online Event';
                $category = $event->category ? $event->category->name : 'General';
                
                $response .= "**{$num}. {$event->name}** 🎭\n";
                $response .= "   📅 {$event->date->format('l, M d, Y')} at {$event->date->format('g:i A')}\n";
                $response .= "   📍 {$venueName}\n";
                $response .= "   🎫 {$category} | {$price}\n\n";
            }
            
            if ($count > 5) {
                $remaining = $count - 5;
                $response .= "_...plus {$remaining} more event" . ($remaining > 1 ? 's' : '') . "! Scroll down to see all the options._ 👇\n\n";
            }
            
            // Add dynamic closing
            $closings = [
                "Click any event card below to see full details and book your spot! 🎟️",
                "Tap on any event to learn more and grab your tickets! 🎫",
                "Interested in any of these? Click to explore details and register! ✨",
                "See something you like? Click the event card for more info! 🚀",
            ];
            $response .= $closings[array_rand($closings)];
            
            return $response;
        }
        
        // No events found - provide helpful, conversational guidance
        $noEventsResponses = [];
        
        if (stripos($message, 'music') !== false || stripos($message, 'concert') !== false) {
            $noEventsResponses[] = "Hmm, I don't see any music events matching that specific criteria right now. 🎵\n\nBut don't worry! Try:\n• 'Show me all upcoming events'\n• 'What's happening this weekend?'\n• 'Events near me'\n\nI might have other great events you'd enjoy!";
        } elseif (stripos($message, 'free') !== false) {
            $noEventsResponses[] = "I couldn't find free events matching that exact search. 💰\n\nHow about we try:\n• 'Show me all available events' (some might be free!)\n• 'Cheap events under $20'\n• 'What events do you have?'\n\nLet's find something great within your budget!";
        } elseif (stripos($message, 'weekend') !== false || stripos($message, 'today') !== false) {
            $noEventsResponses[] = "No events scheduled for that specific timeframe yet. 📅\n\nBut check out:\n• 'Upcoming events' - see what's coming soon\n• 'Next week's events'\n• 'All available events'\n\nThere's always something exciting on the horizon!";
        }
        
        // General fallback based on intent
        if ($intent === 'greeting') {
            $greetings = [
                "Hey there! 👋 Great to chat with you! I'm here to help you discover amazing events. What kind of experiences are you looking for? Music, sports, tech, food festivals? Just ask!",
                "Hello! 😊 I'm your event buddy, and I'm excited to help! Whether you're into concerts, workshops, sports, or networking - I can find something perfect for you. What catches your interest?",
                "Hi! 🎉 Ready to discover some awesome events? I know about concerts, festivals, conferences, workshops and more! What would you like to explore today?",
            ];
            return $greetings[array_rand($greetings)];
        }
        
        if ($intent === 'about_assistant') {
            return "Great question! I'm Event Buddy - your AI-powered event discovery assistant! 🤖✨\n\n**What I can do:**\n• 🔍 Find events by location, category, or date\n• 💰 Help you find events within your budget\n• 📅 Show what's happening today, this weekend, or anytime\n• 🎭 Search across music, sports, tech, food, and more\n• 🎫 Guide you through booking and registration\n\n**How I work:**\nI search our event database in real-time and understand natural language - so just ask me like you'd ask a friend! For example: 'What's happening this weekend?' or 'Find cheap music events near me'.\n\nWhat would you like to discover?";
        }
        
        if ($intent === 'smalltalk') {
            $smalltalk = [
                "I'm doing fantastic, thanks for asking! 😊 I love helping people discover amazing experiences. Speaking of which, what kind of events get you excited? Concerts? Workshops? Festivals?",
                "I'm great! 🌟 Every conversation is a chance to help someone find their next adventure. What about you - what brings you here today? Looking for something specific or just browsing?",
                "Doing wonderful, thank you! 💫 I get energized when I can connect people with events they'll love. What are your interests? Maybe I can suggest something awesome!",
            ];
            return $smalltalk[array_rand($smalltalk)];
        }
        
        if ($intent === 'thanks') {
            $thanks = [
                "You're so welcome! 😊 Happy to help anytime! Is there anything else you'd like to know about events? I'm here for you!",
                "My pleasure! 🎉 That's what I'm here for! Need help with anything else? Just ask!",
                "Absolutely! Glad I could assist! ✨ Feel free to ask me anything else about events!",
            ];
            return $thanks[array_rand($thanks)];
        }
        
        if ($intent === 'goodbye') {
            $goodbyes = [
                "Goodbye! 👋 It was great chatting with you! Come back anytime you need event recommendations. Have an amazing day! 🌟",
                "See you later! 🎉 Thanks for stopping by! Don't forget to check back for new events. Take care! ✨",
                "Bye! 👋 Hope to see you again soon! Enjoy whatever adventure you choose! 🚀",
            ];
            return $goodbyes[array_rand($goodbyes)];
        }
        
        // Default conversational response when no events found
        if (empty($noEventsResponses)) {
            $noEventsResponses = [
                "I couldn't find events matching those exact keywords, but I'm here to help! 🤔\n\nLet's try something different:\n• 'Show me all available events'\n• 'What's happening this weekend?'\n• 'Events near me'\n• 'Music concerts' or 'Sports events'\n\nWhat interests you most?",
                "Hmm, no exact matches for that search. But don't give up! 🔍\n\nTry asking:\n• 'List all upcoming events'\n• 'What events do you have?'\n• 'Show me events by category'\n• Or tell me your interests and I'll search!\n\nWhat would you like to explore?",
                "I didn't find specific events for that query, but I've got plenty more to show you! ✨\n\nHow about:\n• 'All available events'\n• 'Events this week'\n• 'Free events'\n• Just tell me what you're into!\n\nLet's find something perfect for you!",
            ];
        }
        
        return $noEventsResponses[array_rand($noEventsResponses)];
    }

    /**
     * Fallback response when AI API fails (Legacy - keeping for compatibility)
     */
    protected function getFallbackResponse(string $message, array $context, $events = null): string
    {
        if ($events === null) {
            $events = $this->getRelevantEvents($message, $context);
        }

        $intent = $this->detectIntent($message);
        $messageLower = strtolower($message);

        // Greetings
        if ($intent === 'greeting') {
            $greetings = [
                "Hello! 👋 I'm your event discovery assistant. How can I help you find amazing events today?",
                "Hi there! 😊 Ready to discover some great events? What are you interested in?",
                "Hey! 🎉 I'm here to help you find the perfect event. What would you like to explore?",
                "Good day! ✨ Looking for events? I can help you find concerts, festivals, workshops, and more!",
            ];
            return $greetings[array_rand($greetings)];
        }
        
        // About the assistant
        if ($intent === 'about_assistant') {
            return "I'm Event Buddy, your intelligent event discovery assistant! 🤖✨\n\nI can help you:\n🎯 Find events based on your location\n📅 Discover what's happening today, this weekend, or anytime\n🎭 Search by category (music, sports, tech, food, etc.)\n💰 Find events within your budget\n🎫 Guide you through booking tickets\n\nI understand natural language, so just ask me anything! What would you like to explore?";
        }
        
        // Small talk
        if ($intent === 'smalltalk') {
            return "I'm doing great, thank you for asking! 😊\n\nI'm excited to help you discover amazing events. There's always something interesting happening!\n\nWhat kind of events are you interested in? Music, sports, tech conferences, or something else?";
        }
        
        // Thanks
        if ($intent === 'thanks') {
            return "You're very welcome! 😊 I'm happy to help!\n\nIs there anything else you'd like to know about events? I'm here to assist!";
        }
        
        // Goodbye
        if ($intent === 'goodbye') {
            return "Goodbye! 👋 Thanks for chatting with me. Come back anytime you're looking for great events!\n\nHave a wonderful day! 🎉";
        }

        // Location-based search
        if ($intent === 'location_search') {
            if ($events->isNotEmpty()) {
                $response = "Great! I found " . $events->count() . " event" . ($events->count() > 1 ? 's' : '') . " near you:\n\n";
                foreach ($events->take(3) as $event) {
                    $price = $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free';
                    $venueName = $event->venue ? $event->venue->name : 'Online';
                    $response .= "🎉 {$event->name}\n";
                    $response .= "   📅 {$event->date->format('M d, Y')} at {$event->date->format('g:i A')}\n";
                    $response .= "   📍 {$venueName}\n";
                    $response .= "   💰 {$price}\n\n";
                }
                return $response . "Click any event card below to see details and book tickets!";
            }
            return "I couldn't find events near your location right now. 😔\n\nTry:\n• Searching for events by category (music, sports, etc.)\n• Checking what's happening 'this weekend'\n• Browsing all upcoming events";
        }

        // Date-based queries
        if ($intent === 'datetime_query') {
            $timeframe = 'coming up';
            if (stripos($messageLower, 'today') !== false || stripos($messageLower, 'tonight') !== false) $timeframe = 'today';
            elseif (stripos($messageLower, 'tomorrow') !== false) $timeframe = 'tomorrow';
            elseif (stripos($messageLower, 'weekend') !== false) $timeframe = 'this weekend';
            elseif (stripos($messageLower, 'week') !== false) $timeframe = 'this week';
            elseif (stripos($messageLower, 'month') !== false) $timeframe = 'this month';
            
            if ($events->isNotEmpty()) {
                $response = "Perfect! Here's what's happening {$timeframe}:\n\n";
                foreach ($events->take(3) as $event) {
                    $price = $event->price > 0 ? '- $' . number_format($event->price, 2) : '- Free';
                    $venueName = $event->venue ? $event->venue->name : 'Online';
                    $response .= "🎉 {$event->name}\n";
                    $response .= "   📅 {$event->date->format('l, M d')} at {$event->date->format('g:i A')}\n";
                    $response .= "   📍 {$venueName} {$price}\n\n";
                }
                return $response . "Click on any event to book tickets!";
            }
            return "No events scheduled {$timeframe} yet. Check out our upcoming events or try a different date!";
        }

        // Pricing queries
        if ($intent === 'pricing') {
            // Extract price limit if mentioned
            $priceLimit = null;
            if (preg_match('/under\s*\$(\d+)|less than\s*\$(\d+)|below\s*\$(\d+)/', $messageLower, $matches)) {
                $priceLimit = (int) ($matches[1] ?? $matches[2] ?? $matches[3]);
            }
            
            if ($events->isNotEmpty()) {
                $header = $priceLimit ? "Great! Here are events under \${$priceLimit}:" : "Here are some events with pricing:";
                $response = $header . "\n\n";
                foreach ($events->take(3) as $event) {
                    $price = $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free';
                    $response .= "🎉 {$event->name}\n";
                    $response .= "   💰 {$price}\n";
                    $response .= "   📅 {$event->date->format('M d, Y')}\n\n";
                }
                return $response . "Click any event to see details and book!";
            }
            return "Looking for events with specific pricing? Try searching by category or date, and I'll show you the prices!";
        }

        // Booking help
        if ($intent === 'booking') {
            if ($events->isNotEmpty()) {
                return "Ready to book? Here are some great events:\n\nCheck the event cards below - just click on any event to see full details and book your tickets!\n\nBooking is easy:\n✓ Secure payment\n✓ Instant confirmation\n✓ E-tickets delivered to your email";
            }
            return "To book tickets:\n\n1. 📱 Browse events below or search for what interests you\n2. 👀 Click on an event to see full details\n3. 🎫 Click 'Book Tickets' or 'Register'\n4. 💳 Complete your booking with secure payment\n\nWhat type of event are you looking for?";
        }

        // General help
        if ($intent === 'help') {
            return "Hi there! I'm your event discovery assistant. 🎉\n\nI can help you with:\n\n🔍 Finding events by location, date, or category\n🎫 Booking tickets and registration\n💰 Checking prices and availability\n📅 Seeing what's happening today, weekend, or upcoming\n🎭 Suggesting events based on your interests\n\nJust ask me naturally! For example:\n• 'Show me events near me'\n• 'What's on this weekend?'\n• 'Find music concerts'\n• 'Cheap events under $20'\n• 'Tech conferences this month'\n\nWhat would you like to explore?";
        }

        // General search - Events found
        if ($intent === 'search' || $intent === 'general') {
            if ($events->isNotEmpty()) {
                $first = $events->first();
                $count = $events->count();
                $response = "Awesome! I found {$count} event" . ($count > 1 ? 's' : '') . " for you:\n\n";
                foreach ($events->take(3) as $event) {
                    $price = $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free';
                    $venueName = $event->venue ? $event->venue->name : 'Online';
                    $response .= "🎉 {$event->name}\n";
                    $response .= "   📅 {$event->date->format('M d, Y')} at {$event->date->format('g:i A')}\n";
                    $response .= "   📍 {$venueName}\n";
                    $response .= "   💰 {$price}\n\n";
                }
                return $response . "Click any event card to see full details and book!";
            }
        }
        
        // If we get here and still have events, show them (no specific intent matched)
        if ($events->isNotEmpty()) {
            $count = $events->count();
            $response = "Here are {$count} upcoming event" . ($count > 1 ? 's' : '') . " you might enjoy:\n\n";
            foreach ($events->take(3) as $event) {
                $price = $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free';
                $venueName = $event->venue ? $event->venue->name : 'Online';
                $category = $event->category ? $event->category->name : 'General';
                $response .= "🎉 **{$event->name}**\n";
                $response .= "   📅 {$event->date->format('l, M d, Y')} at {$event->date->format('g:i A')}\n";
                $response .= "   📍 {$venueName}\n";
                $response .= "   🎭 {$category}\n";
                $response .= "   💰 {$price}\n\n";
            }
            if ($count > 3) {
                $response .= "...and " . ($count - 3) . " more event" . ($count - 3 > 1 ? 's' : '') . "! Scroll down to see all event cards.\n\n";
            }
            return $response . "Click any event card below to see full details and book tickets! 🎫";
        }

        // No events found - Smart suggestions
        $suggestions = [];
        if (stripos($messageLower, 'music') !== false) {
            $suggestions[] = "Try: 'concerts this weekend' or 'live music tonight'";
        }
        if (stripos($messageLower, 'sports') !== false) {
            $suggestions[] = "Try: 'sports events near me' or 'games this week'";
        }
        if (empty($suggestions)) {
            $suggestions = [
                "'Show me events near me' 📍",
                "'What's happening this weekend?' 📅",
                "'Find music events' 🎵",
                "'Free events' 💰",
            ];
        }
        
        return "I couldn't find events matching that exactly. 🤔\n\nLet me help you discover something great!\n\nTry asking:\n" . implode("\n", array_map(fn($s) => "• {$s}", $suggestions)) . "\n\nWhat interests you?";
    }

    /**
     * Get conversation history
     */
    public function getHistory(string $sessionId, int $limit = 10)
    {
        return ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * Save message to database
     */
    public function saveMessage(array $data): ChatMessage
    {
        return ChatMessage::create($data);
    }
}
