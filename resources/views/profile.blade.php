<x-app-layout>
    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-black">Profile Settings</h1>
                            <p class="text-sm text-gray-900">Manage your account settings and preferences</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        @if(auth()->user()->role === 'admin')
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-blue-600 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @if(auth()->user()->is_super_admin) Super Admin @else Admin @endif
                            </span>
                        @endif
                        
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-5 py-2.5 border-2 border-blue-500 text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 transition-all duration-300 shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)]">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= PAGE CONTAINER ================= --}}
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= PROFILE OVERVIEW CARD ================= --}}
            <div class="bg-gradient-to-r from-white to-blue-50 rounded-2xl shadow-sm border border-blue-50 p-6">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    {{-- Avatar --}}
                    <div class="relative group">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-24 h-24 rounded-full object-cover ring-4 ring-white shadow-md">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-md">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <a href="#photo-upload" class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center cursor-pointer">
                            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </div>

                    {{-- User Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-black mb-2">{{ auth()->user()->name }}</h2>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-900">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ auth()->user()->email }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Member since {{ auth()->user()->created_at->format('F Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Account Status --}}
                    <div class="flex flex-col gap-2">
                        @if(auth()->user()->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Email Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Email Not Verified
                            </span>
                        @endif
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-1"></div>
                            Active
                        </span>
                    </div>
                </div>
            </div>

            {{-- ================= STATS OVERVIEW ================= --}}
            <div class="bg-gradient-to-r from-white to-blue-50 rounded-2xl shadow-sm border border-blue-50 p-6">
                <h3 class="text-lg font-bold text-black mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Your Activity Overview
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $userEvents = \App\Models\Event::where('user_id', auth()->id())->count();
                    $userBookings = \App\Models\Booking::where('user_id', auth()->id())->count();
                    $userFavorites = auth()->user()->favoritedEvents()->count();
                    $userRevenue = \App\Models\Event::where('user_id', auth()->id())
                        ->with('bookings.payment')
                        ->get()
                        ->sum(function($event) {
                            return $event->bookings->sum(function($booking) {
                                return $booking->payment ? $booking->payment->amount : 0;
                            });
                        });
                @endphp

                {{-- Events Created --}}
                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-black mb-1">Events Created</p>
                            <p class="text-3xl font-bold text-black">{{ $userEvents }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gradient-to-r from-blue-200 to-blue-300 rounded-full"></div>
                </div>

                {{-- Bookings Made --}}
                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-black mb-1">Bookings Made</p>
                            <p class="text-3xl font-bold text-black">{{ $userBookings }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gradient-to-r from-blue-200 to-blue-300 rounded-full"></div>
                </div>

                {{-- Favorites --}}
                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-black mb-1">Favorite Events</p>
                            <p class="text-3xl font-bold text-black">{{ $userFavorites }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gradient-to-r from-blue-200 to-blue-300 rounded-full"></div>
                </div>

                {{-- Revenue/Spending --}}
                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-black mb-1">Total Revenue</p>
                            <p class="text-3xl font-bold text-black">${{ number_format($userRevenue, 2) }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gradient-to-r from-blue-200 to-blue-300 rounded-full"></div>
                </div>
                </div>
            </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- LEFT COLUMN - Main Settings --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Profile Photo Upload Card --}}
                    <div id="photo-upload" class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                            <h3 class="text-lg font-bold text-black flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Profile Photo
                            </h3>
                            <p class="text-sm text-gray-900 mt-1">Upload or update your profile picture</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-profile-photo />
                        </div>
                    </div>

                    {{-- Profile Information Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                            <h3 class="text-lg font-bold text-black flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile Information
                            </h3>
                            <p class="text-sm text-gray-900 mt-1">Update your account information and email address</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>

                    {{-- Update Password Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                            <h3 class="text-lg font-bold text-black flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Update Password
                            </h3>
                            <p class="text-sm text-gray-900 mt-1">Ensure your account is using a long, random password to stay secure</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    {{-- Delete Account Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                        <div class="p-6 bg-red-50 border-b border-red-100">
                            <h3 class="text-lg font-bold text-black flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Delete Account
                            </h3>
                            <p class="text-sm text-gray-900 mt-1">Permanently delete your account and all of its data</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN - Quick Access & Info --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Quick Links Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-6">
                        <h4 class="text-lg font-bold text-black mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Links
                        </h4>
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-black group-hover:text-blue-600">Dashboard</span>
                            </a>

                            <a href="{{ route('events.create.user') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-black group-hover:text-blue-600">Create Event</span>
                            </a>

                            <a href="{{ route('events.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-black group-hover:text-blue-600">Browse Events</span>
                            </a>

                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-black group-hover:text-blue-600">Admin Dashboard</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Account Info Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-6">
                        <h4 class="text-lg font-bold text-black mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Account Info
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-900">Role</span>
                                <span class="text-sm font-bold text-black">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-900">Member Since</span>
                                <span class="text-sm font-bold text-black">{{ auth()->user()->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-900">Last Updated</span>
                                <span class="text-sm font-bold text-black">{{ auth()->user()->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-900">Status</span>
                                <span class="inline-flex items-center gap-1 text-sm font-bold text-green-700">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Activity Notice Card --}}
                    <div class="bg-blue-50 rounded-2xl border border-blue-100 p-6">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-black mb-1">Activity Log</h5>
                                <p class="text-xs text-gray-900 mb-3">Track your account activity and view your action history.</p>
                                <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">Coming Soon</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
