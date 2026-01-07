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

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user'; // Set default role for new users

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        return $this->redirect(route('dashboard'), navigate: true);
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

                <form wire:submit="register" class="space-y-6">
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
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a class="text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200" href="{{ route('login') }}" wire:navigate>
                            {{ __('Already have an account?') }}
                        </a>

                        <x-primary-button>
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
