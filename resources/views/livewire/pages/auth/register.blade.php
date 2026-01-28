<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $recaptcha_token = '';

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];

        // Only require reCAPTCHA if it's configured
        if (config('services.recaptcha.secret_key')) {
            $rules['recaptcha_token'] = ['required'];
        }

        $validated = $this->validate($rules);

        // Verify reCAPTCHA only if configured
        if (config('services.recaptcha.secret_key')) {
            if (!$this->verifyRecaptcha($validated['recaptcha_token'] ?? '')) {
                $this->addError('recaptcha_token', 'reCAPTCHA verification failed. Please try again.');
                return;
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user'; // Set default role for new users

        $user = User::create($validated);
        event(new Registered($user));

        // Don't auto-login - redirect to email verification notice
        session()->flash('status', 'Registration successful! Please check your email to verify your account.');
        return $this->redirect(route('verification.notice'), navigate: true);
    }

    /**
     * Verify reCAPTCHA token
     */
    protected function verifyRecaptcha($token)
    {
        if (!config('services.recaptcha.secret_key') || empty($token)) {
            // If reCAPTCHA is not configured or no token provided, skip verification
            return true;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => request()->ip()
            ]);

            return $response->json('success', false) && $response->json('score', 0) >= 0.5;
        } catch (\Exception $e) {
            // If verification fails due to network issues, allow registration in development
            return app()->environment('local') ? true : false;
        }
    }

    /**
     * Compatibility stub: some Livewire clients call `toJSON` on components.
     * Provide a harmless response to avoid MethodNotFoundException.
     */
    public function toJSON()
    {
        return [];
    }
}; ?>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 flex items-center justify-center px-7">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl p-12 border border-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                    <p class="text-gray-600">Join us and start managing your events</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form wire:submit="register" class="space-y-6" x-data="{ submitForm(e) { 
                    e.preventDefault(); 
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.ready(function() {
                            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'register'}).then(function(token) {
                                @this.set('recaptcha_token', token);
                                @this.call('register');
                            });
                        });
                    } else {
                        @this.call('register');
                    }
                } }" x-on:submit="submitForm($event)">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" placeholder="Enter your full name" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" placeholder="Enter your email address" />
                        <x-input-error :messages="$errors->get('email')" />
                        <p class="mt-1 text-xs text-gray-500">We'll send you a verification link to confirm your email</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
                        <x-input-error :messages="$errors->get('password')" />
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>

                    <!-- reCAPTCHA Error -->
                    <x-input-error :messages="$errors->get('recaptcha_token')" />

                    <!-- Terms Notice -->
                    <div class="flex items-start gap-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <p class="text-xs text-blue-700">
                            By creating an account, you agree to verify your email address. This helps us ensure real users and protect our community.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 gap-4">
                        <a class="text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200" href="{{ route('login') }}" wire:navigate>
                            {{ __('Already have an account?') }}
                        </a>

                        <x-primary-button class="w-full sm:w-auto py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-2xl">
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>

                    <!-- reCAPTCHA Badge Info -->
                    @if(config('services.recaptcha.site_key'))
                        <p class="text-xs text-gray-500 text-center mt-4">
                            This site is protected by reCAPTCHA and the Google
                            <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-600 hover:underline">Privacy Policy</a> and
                            <a href="https://policies.google.com/terms" target="_blank" class="text-blue-600 hover:underline">Terms of Service</a> apply.
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @if(config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endif
