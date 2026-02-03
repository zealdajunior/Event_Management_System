<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Modern Logo/Brand -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 group">
                        <div class="p-2 bg-white rounded-xl shadow-md group-hover:shadow-lg transition-all duration-300">
                            <svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">Event<span class="text-blue-200">Hub</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" wire:navigate 
                       class="{{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }} px-4 py-2 rounded-xl font-bold text-sm transition-all duration-300">
                        Dashboard
                    </a>
                    
                    <a href="{{ route('calendar.index') }}" wire:navigate 
                       class="{{ request()->routeIs('calendar.*') ? 'bg-white/20 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }} px-4 py-2 rounded-xl font-bold text-sm transition-all duration-300">
                        Calendar
                    </a>
                    
                    <a href="{{ route('calendar.map') }}" wire:navigate 
                       class="{{ request()->routeIs('calendar.map') ? 'bg-white/20 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }} px-4 py-2 rounded-xl font-bold text-sm transition-all duration-300">
                        Map
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md">
                            <div class="p-1.5 bg-white rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4" fill="currentColor" opacity="0.8"/>
                                    <path d="M4 20c0-4 3.5-7 8-7s8 3 8 7" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-600">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" wire:navigate 
               class="{{ request()->routeIs('dashboard') ? 'bg-white/20 text-white border-l-4 border-white' : 'text-blue-100 hover:bg-white/10 hover:text-white border-l-4 border-transparent' }} block ps-3 pe-4 py-2 text-base font-bold transition-all duration-300">
                Dashboard
            </a>
            
            <a href="{{ route('calendar.index') }}" wire:navigate 
               class="{{ request()->routeIs('calendar.*') ? 'bg-white/20 text-white border-l-4 border-white' : 'text-blue-100 hover:bg-white/10 hover:text-white border-l-4 border-transparent' }} block ps-3 pe-4 py-2 text-base font-bold transition-all duration-300">
                Calendar
            </a>
            
            <a href="{{ route('calendar.map') }}" wire:navigate 
               class="{{ request()->routeIs('calendar.map') ? 'bg-white/20 text-white border-l-4 border-white' : 'text-blue-100 hover:bg-white/10 hover:text-white border-l-4 border-transparent' }} block ps-3 pe-4 py-2 text-base font-bold transition-all duration-300">
                Map
            </a>
            
            <!-- Quick Actions for Mobile -->
            <div class="px-3 py-2">
                <div class="text-xs font-bold text-blue-200 uppercase tracking-wider mb-2">Quick Actions</div>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('events.create') }}" wire:navigate 
                       class="flex items-center gap-3 text-blue-100 hover:bg-white/10 hover:text-white ps-2 pe-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300 mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Event
                    </a>
                    <a href="{{ route('venues.create') }}" wire:navigate 
                       class="flex items-center gap-3 text-blue-100 hover:bg-white/10 hover:text-white ps-2 pe-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Add Venue
                    </a>
                @else
                    <a href="{{ route('events.create.user') }}" wire:navigate 
                       class="flex items-center gap-3 text-blue-100 hover:bg-white/10 hover:text-white ps-2 pe-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300 mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Event
                    </a>
                    <a href="{{ route('event-requests.create') }}" wire:navigate 
                       class="flex items-center gap-3 text-blue-100 hover:bg-white/10 hover:text-white ps-2 pe-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Request Approval
                    </a>
                @endif
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4">
                <div class="font-bold text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-blue-100">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile') }}" wire:navigate 
                   class="block ps-3 pe-4 py-2 text-base font-bold text-blue-100 hover:bg-white/10 hover:text-white border-l-4 border-transparent transition-all duration-300">
                    Profile
                </a>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start ps-3 pe-4 py-2 text-base font-bold text-blue-100 hover:bg-white/10 hover:text-white border-l-4 border-transparent transition-all duration-300">
                    Log Out
                </button>
            </div>
        </div>
    </div>
</nav>
