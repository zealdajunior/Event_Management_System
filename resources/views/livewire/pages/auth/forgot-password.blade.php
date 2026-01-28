<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetCode;
use App\Models\PasswordResetCode as PasswordResetCodeModel;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public bool $codeRequested = false;
    public string $successMessage = '';
    public string $errorMessage = '';

    /**
     * Send a password reset code to the provided email address.
     */
    public function sendPasswordResetCode(): void
    {
        $this->errorMessage = '';
        $this->successMessage = '';

        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Check if user exists with this email
        $userExists = \App\Models\User::where('email', $this->email)->exists();
        
        // Store email in session for the verify page
        session(['reset_email' => $this->email]);
        
        if ($userExists) {
            try {
                // Create a new password reset code
                $resetCode = PasswordResetCodeModel::createForEmail($this->email);

                // Send the reset code via email
                Mail::to($this->email)->send(new PasswordResetCode($resetCode->code));
                
                // Add success message to session
                session()->flash('status', 'A 6-digit reset code has been sent to your email. Please check your inbox.');
            } catch (\Exception $e) {
                \Log::error('Password reset code sending error: ' . $e->getMessage());
                // Still redirect but with error message
                session()->flash('error', 'An error occurred while sending the code. Please try again.');
            }
        } else {
            // For security, don't reveal if email exists - still show same message
            session()->flash('status', 'If an account exists with that email, a reset code has been sent.');
        }
        
        // Always redirect to verify code page
        $this->redirectRoute('password.verify-code', navigate: true);
    }

    /**
     * Reset the form
     */
    public function resetForm(): void
    {
        $this->email = '';
        $this->codeRequested = false;
        $this->successMessage = '';
        $this->errorMessage = '';
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 px-4 relative overflow-hidden">
    <!-- Animated Background Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-200 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-300 rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay: 1s"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8 form-container">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl mb-6 shadow-xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-black text-blue-600 mb-3">
                {{ __('Forgot Password?') }}
            </h1>
            <p class="text-gray-600 text-lg">
                {{ __('No worries! Enter your email and we\'ll send you a reset code.') }}
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-blue-100 card-shine">
            <!-- Success Message -->
            @if ($successMessage)
                <div class="mb-6 p-5 bg-blue-50 border-2 border-blue-200 rounded-2xl form-field">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-blue-800 font-semibold">
                                {{ $successMessage }}
                            </p>
                            <button
                                wire:click="resetForm"
                                class="mt-2 text-sm text-blue-600 hover:text-blue-700 hover:underline font-semibold transition"
                            >
                                {{ __('Send another code') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if ($errorMessage)
                <div class="mb-6 p-5 bg-red-50 border-2 border-red-200 rounded-2xl form-field">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-800 font-semibold flex-1">
                            {{ $errorMessage }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            @if (!$codeRequested)
                <form wire:submit="sendPasswordResetCode" class="space-y-6">
                    <!-- Email Address -->
                    <div class="form-field">
                        <label for="email" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            {{ __('Email Address') }}
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                wire:model="email" 
                                id="email"
                                name="email"
                                required 
                                autofocus
                                placeholder="{{ __('your.email@example.com') }}"
                                class="form-input w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-gray-50 focus:bg-white transition-all duration-300 text-base"
                            />
                            <div class="input-focus-ring"></div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="primary-btn w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-black text-lg rounded-xl shadow-lg hover:shadow-blue-500/50 transform hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('Send Reset Code') }}</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-3">
                {{ __('Remember your password?') }}
            </p>
            <a href="{{ route('login') }}" wire:navigate class="link-hover inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-bold text-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</div>
