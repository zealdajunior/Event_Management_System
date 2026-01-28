<?php

use App\Models\PasswordResetCode as PasswordResetCodeModel;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $code = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $errorMessage = '';
    public bool $codeVerified = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->email = session('reset_email', '');
    }

    /**
     * Verify the reset code.
     */
    public function verifyCode(): void
    {
        $this->errorMessage = '';

        $this->validate([
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        // Find valid code for this email
        $resetCode = PasswordResetCodeModel::byEmail($this->email)
            ->byCode($this->code)
            ->valid()
            ->first();

        if (!$resetCode) {
            $this->errorMessage = 'The reset code is invalid or has expired. Please request a new code.';
            return;
        }

        $this->codeVerified = true;
    }

    /**
     * Reset the password.
     */
    public function resetPassword(): void
    {
        $this->errorMessage = '';

        $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$this->codeVerified) {
            $this->errorMessage = 'Please verify your reset code first.';
            return;
        }

        // Verify code again for security
        $resetCode = PasswordResetCodeModel::byEmail($this->email)
            ->byCode($this->code)
            ->valid()
            ->first();

        if (!$resetCode) {
            $this->errorMessage = 'The reset code has expired. Please request a new code.';
            return;
        }

        // Find and update the user
        $user = \App\Models\User::where('email', $this->email)->first();

        if (!$user) {
            $this->errorMessage = 'User not found.';
            return;
        }

        try {
            $user->update([
                'password' => bcrypt($this->password),
            ]);

            // Delete the used reset code
            $resetCode->delete();

            // Clear session
            session()->forget('reset_email');

            session()->flash('status', 'Your password has been reset successfully. Please log in with your new password.');
            $this->redirectRoute('login', navigate: true);
        } catch (\Exception $e) {
            $this->errorMessage = 'An error occurred while resetting your password. Please try again.';
            \Log::error('Password reset error: ' . $e->getMessage());
        }
    }

    /**
     * Go back to edit code
     */
    public function editCode(): void
    {
        $this->codeVerified = false;
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
    }

    /**
     * Go back to request new code
     */
    public function requestNewCode(): void
    {
        session()->forget('reset_email');
        $this->redirectRoute('password.request', navigate: true);
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
                @if($codeVerified)
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                @else
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <h1 class="text-4xl font-black text-blue-600 mb-3">
                @if($codeVerified)
                    {{ __('Set New Password') }}
                @else
                    {{ __('Verify Reset Code') }}
                @endif
            </h1>
            <p class="text-gray-600 text-lg">
                @if($codeVerified)
                    {{ __('Enter your new password below') }}
                @else
                    {{ __('Enter the 6-digit code sent to your email') }}
                @endif
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-blue-100 card-shine">
            <!-- Success Message from Session -->
            @if (session('status'))
                <div class="mb-6 p-5 bg-blue-50 border-2 border-blue-200 rounded-2xl form-field">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-blue-800 font-semibold flex-1">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Error Message from Session -->
            @if (session('error'))
                <div class="mb-6 p-5 bg-red-50 border-2 border-red-200 rounded-2xl form-field">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-800 font-semibold flex-1">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Error Message from Component -->
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

            @if(!$codeVerified)
                <!-- Code Verification Form -->
                <form wire:submit="verifyCode" class="space-y-6">
                    <!-- Email Address -->
                    <div class="form-field">
                        <label for="email" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            {{ __('Email') }}
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

                    <!-- Code -->
                    <div class="form-field">
                        <label for="code" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            {{ __('Reset Code') }}
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                wire:model="code" 
                                id="code"
                                name="code"
                                required
                                placeholder="000000"
                                maxlength="6"
                                autocomplete="one-time-code"
                                class="form-input w-full px-5 py-6 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-gray-50 focus:bg-white transition-all duration-300 text-center text-3xl font-mono tracking-[0.5em] font-bold"
                            />
                            <div class="input-focus-ring"></div>
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            {{ __('Check your email for the 6-digit code. It expires in 15 minutes.') }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-4 pt-2">
                        <button 
                            type="submit"
                            class="primary-btn w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-black text-lg rounded-xl shadow-lg hover:shadow-blue-500/50 transform hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ __('Verify Code') }}</span>
                        </button>

                        <button
                            type="button"
                            wire:click="requestNewCode"
                            class="text-center text-blue-600 hover:text-blue-700 font-semibold transition py-2 hover:underline"
                        >
                            {{ __('Didn\'t receive the code? Request new one') }}
                        </button>
                    </div>
                </form>
            @else
                <!-- Password Reset Form -->
                <form wire:submit="resetPassword" class="space-y-6">
                    <!-- Success Badge -->
                    <div class="mb-6 p-5 bg-green-50 border-2 border-green-200 rounded-2xl form-field">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-green-800 font-semibold">
                                    {{ __('Code verified successfully!') }}
                                </p>
                                <button
                                    type="button"
                                    wire:click="editCode"
                                    class="mt-1 text-sm text-green-600 hover:text-green-700 hover:underline font-medium transition"
                                >
                                    {{ __('Use a different code') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="form-field" x-data="{ showPassword: false }">
                        <label for="password" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('New Password') }}
                        </label>
                        <div class="input-wrapper relative">
                            <input 
                                ::type="showPassword ? 'text' : 'password'"
                                wire:model="password" 
                                id="password"
                                name="password"
                                required
                                autofocus
                                placeholder="••••••••"
                                autocomplete="new-password"
                                class="form-input w-full px-5 py-4 pr-12 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-gray-50 focus:bg-white transition-all duration-300 text-base"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors focus:outline-none"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                            <div class="input-focus-ring"></div>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            {{ __('Must be at least 8 characters long') }}
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-field" x-data="{ showConfirmPassword: false }">
                        <label for="password_confirmation" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            {{ __('Confirm Password') }}
                        </label>
                        <div class="input-wrapper relative">
                            <input 
                                ::type="showConfirmPassword ? 'text' : 'password'"
                                wire:model="password_confirmation" 
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="••••••••"
                                autocomplete="new-password"
                                class="form-input w-full px-5 py-4 pr-12 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-gray-50 focus:bg-white transition-all duration-300 text-base"
                            />
                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors focus:outline-none"
                            >
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                            <div class="input-focus-ring"></div>
                        </div>
                            />
                            <div class="input-focus-ring"></div>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit"
                            class="primary-btn w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-black text-lg rounded-xl shadow-lg hover:shadow-blue-500/50 transform hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Reset Password') }}</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" wire:navigate class="link-hover inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-bold text-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</div>
