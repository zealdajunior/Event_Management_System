<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function step1()
    {
        if (Auth::user()->onboarding_completed) {
            return redirect()->route('user.dashboard');
        }
        return view('onboarding.step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'location' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'occupation' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('onboarding.step2');
    }

    public function step2()
    {
        if (Auth::user()->onboarding_completed) {
            return redirect()->route('user.dashboard');
        }
        return view('onboarding.step2');
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'interests' => 'required|array|min:1',
            'interests.*' => 'string',
        ]);

        $user = Auth::user();
        $user->update([
            'interests' => $validated['interests']
        ]);

        return redirect()->route('onboarding.step3');
    }

    public function step3()
    {
        if (Auth::user()->onboarding_completed) {
            return redirect()->route('user.dashboard');
        }
        return view('onboarding.step3');
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'favorite_event_types' => 'required|string',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update([
            'favorite_event_types' => $validated['favorite_event_types'],
            'bio' => $validated['bio'] ?? null,
            'onboarding_completed' => true,
        ]);

        return redirect()->route('user.dashboard')->with('status', 'Welcome! Your profile is all set up.');
    }

    public function skip()
    {
        $user = Auth::user();
        $user->update(['onboarding_completed' => true]);
        
        return redirect()->route('user.dashboard');
    }
}
