<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $location = '';
    public string $date_of_birth = '';
    public string $occupation = '';
    public array $interests = [];
    public string $favorite_event_types = '';
    public string $bio = '';
    public bool $emailChanged = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->location = $user->location ?? '';
        $this->date_of_birth = $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '';
        $this->occupation = $user->occupation ?? '';
        $this->interests = $user->interests ?? [];
        $this->favorite_event_types = $user->favorite_event_types ?? '';
        $this->bio = $user->bio ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'location' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'interests' => ['nullable', 'array'],
            'favorite_event_types' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $this->emailChanged = true;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        
        if ($this->emailChanged) {
            Session::flash('status', 'email-changed');
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <form wire:submit="updateProfileInformation" class="space-y-5">
        <!-- Success Message -->
        @if (session('status') === 'email-changed')
            <div class="p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-bold text-gray-700">Email updated. Please verify your new email address.</p>
                </div>
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                Full Name
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.5-7 8-7s8 3 8 7" stroke-linecap="round"/>
                    </svg>
                </div>
                <input wire:model="name" id="name" name="name" type="text" 
                       class="block w-full pl-10 pr-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                       placeholder="Enter your full name"
                       required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                Email Address
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input wire:model="email" id="email" name="email" type="email" 
                       class="block w-full pl-10 pr-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                       placeholder="your.email@example.com"
                       required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-yellow-50 rounded-xl border-l-4 border-yellow-500">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-700 mb-2">
                                Email verification required
                            </p>
                            <p class="text-sm text-gray-600 mb-3">
                                Your email address is not verified. Please check your inbox for a verification link.
                            </p>
                            <button wire:click.prevent="sendVerification" 
                                    type="button"
                                    class="text-sm px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-bold transition-all duration-300">
                                Resend Verification Email
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-3 text-sm font-bold text-yellow-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Verification email sent! Check your inbox.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Essential Information Section -->
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Essential Information
            </h3>
            
            <div class="space-y-5">
                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-xl">📍</span>
                        <span>Location</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <input wire:model="location" id="location" name="location" type="text" 
                               class="block w-full pl-10 pr-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                               placeholder="e.g., New York, USA"/>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-xl">🎂</span>
                        <span>Date of Birth</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input wire:model="date_of_birth" id="date_of_birth" name="date_of_birth" type="date" 
                               class="block w-full pl-10 pr-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300"/>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                </div>

                <!-- Occupation -->
                <div>
                    <label for="occupation" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-xl">💼</span>
                        <span>Occupation</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input wire:model="occupation" id="occupation" name="occupation" type="text" 
                               class="block w-full pl-10 pr-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                               placeholder="e.g., Software Engineer, Student, Designer"/>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
                </div>

                <!-- Interests -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-xl">💖</span>
                        <span>Your Interests</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @php
                            $availableInterests = [
                                'Music' => '🎵',
                                'Technology' => '💻',
                                'Sports' => '⚽',
                                'Art' => '🎨',
                                'Food' => '🍕',
                                'Travel' => '✈️',
                                'Business' => '💼',
                                'Health' => '🏥',
                                'Education' => '📚',
                                'Entertainment' => '🎭',
                                'Gaming' => '🎮',
                                'Fashion' => '👔'
                            ];
                        @endphp
                        @foreach($availableInterests as $interest => $emoji)
                            <label class="relative cursor-pointer group">
                                <input type="checkbox" wire:model="interests" value="{{ $interest }}" class="peer hidden">
                                <div class="flex flex-col items-center justify-center p-3 bg-blue-50 border-2 border-blue-100 rounded-xl hover:border-blue-400 hover:shadow-md transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-100 peer-checked:shadow-lg">
                                    <span class="text-2xl mb-1 transform group-hover:scale-110 transition-transform">{{ $emoji }}</span>
                                    <span class="text-xs font-bold text-gray-700 peer-checked:text-blue-700">{{ $interest }}</span>
                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-all shadow-lg">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('interests')" />
                </div>

                <!-- Favorite Event Types -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-xl">🎯</span>
                        <span>Favorite Event Type</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @php
                            $eventTypes = [
                                'conferences' => ['label' => 'Conferences & Seminars', 'icon' => '🎓'],
                                'concerts' => ['label' => 'Concerts & Music', 'icon' => '🎵'],
                                'sports' => ['label' => 'Sports Events', 'icon' => '⚽'],
                                'workshops' => ['label' => 'Workshops & Training', 'icon' => '🛠️'],
                                'networking' => ['label' => 'Networking Events', 'icon' => '🤝'],
                                'festivals' => ['label' => 'Festivals & Fairs', 'icon' => '🎪']
                            ];
                        @endphp
                        @foreach($eventTypes as $value => $data)
                            <label class="relative cursor-pointer group">
                                <input type="radio" wire:model="favorite_event_types" value="{{ $value }}" class="peer hidden">
                                <div class="flex items-center gap-3 p-4 bg-blue-50 border-2 border-blue-100 rounded-xl hover:border-blue-400 hover:shadow-md transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-100 peer-checked:shadow-lg">
                                    <span class="text-2xl">{{ $data['icon'] }}</span>
                                    <span class="flex-1 text-sm font-bold text-gray-700 peer-checked:text-blue-700">{{ $data['label'] }}</span>
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500 transition-all">
                                        <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('favorite_event_types')" />
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-xl">✍️</span>
                        <span>About You</span>
                    </label>
                    <div class="relative">
                        <textarea wire:model="bio" id="bio" name="bio" rows="4" maxlength="500"
                                  class="block w-full px-4 py-3 bg-blue-50 border-0 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300 resize-none" 
                                  placeholder="Share your story, hobbies, or what excites you about events..."></textarea>
                        <p class="mt-2 text-sm text-gray-500">✨ Max 500 characters</p>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>

            <x-action-message class="text-sm font-bold text-blue-600 flex items-center gap-2" on="profile-updated">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Profile updated successfully!
            </x-action-message>
        </div>
    </form>
</section>
