<x-app-layout>
    {{-- ================= PROFILE HERO SECTION ================= --}}
    <div class="relative">
        {{-- Cover Image --}}
        <div class="h-64 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        {{-- Profile Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative -mt-32 pb-8">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        {{-- Avatar --}}
                        <div class="relative group">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-32 h-32 rounded-full object-cover shadow-2xl ring-4 ring-white">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-4xl font-black shadow-2xl ring-4 ring-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <a href="#photo-upload" class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center cursor-pointer">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>

                        {{-- User Info --}}
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                                <h1 class="text-3xl font-black text-gray-900">{{ auth()->user()->name }}</h1>
                                @if(auth()->user()->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-purple-500 to-blue-600 text-white shadow-md">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Admin
                                    </span>
                                    @if(auth()->user()->is_super_admin)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-orange-500 to-pink-600 text-white shadow-md">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Super Admin
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md">
                                        User
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-3 flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ auth()->user()->email }}
                            </p>
                            
                            <p class="text-sm text-gray-500 flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Member since {{ auth()->user()->created_at->format('F Y') }}
                            </p>
                        </div>

                        {{-- Quick Actions --}}
                        <div class="flex gap-3">
                            <a href="{{ route('audit-log.index') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Activity Log
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= STATS OVERVIEW ================= --}}
    <div class="bg-gradient-to-br from-gray-50 to-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
                <div class="bg-white rounded-2xl p-6 shadow-md border border-blue-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">{{ $userEvents }}</p>
                    <p class="text-sm text-gray-600 font-medium">Events Created</p>
                </div>

                {{-- Bookings Made --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-purple-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">{{ $userBookings }}</p>
                    <p class="text-sm text-gray-600 font-medium">Bookings Made</p>
                </div>

                {{-- Favorites --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-pink-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">{{ $userFavorites }}</p>
                    <p class="text-sm text-gray-600 font-medium">Favorite Events</p>
                </div>

                {{-- Revenue/Spending --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-green-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">${{ number_format($userRevenue, 2) }}</p>
                    <p class="text-sm text-gray-600 font-medium">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LEFT COLUMN - Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Profile Photo Upload Card --}}
                    <div id="photo-upload" class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                <div class="p-2 bg-white rounded-xl shadow-sm">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                Profile Photo
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Upload or update your profile picture.</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-profile-photo />
                        </div>
                    </div>

                    {{-- Profile Information Card --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                <div class="p-2 bg-white rounded-xl shadow-sm">
                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                    </svg>
                                </div>
                                Profile Information
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Update your account's profile information and email address.</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>

                    {{-- Update Password Card --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                <div class="p-2 bg-white rounded-xl shadow-sm">
                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <rect x="5" y="11" width="14" height="10" rx="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="1" fill="currentColor"/>
                                        <path d="M9 11V7a3 3 0 016 0v4" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                Update Password
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    {{-- Delete Account Card --}}
                    <div class="bg-white rounded-3xl shadow-md border border-red-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-red-50 to-orange-50 border-b border-red-100">
                            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                <div class="p-2 bg-white rounded-xl shadow-sm">
                                    <svg class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M15 9l-6 6M9 9l6 6" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                Delete Account
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Permanently delete your account and all of its data.</p>
                        </div>
                        <div class="p-6">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN - Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Quick Links Card --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">
                        <h4 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Links
                        </h4>
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600">Dashboard</span>
                            </a>

                            <a href="{{ route('events.create.user') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-50 transition-colors duration-200 group">
                                <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-700 group-hover:text-purple-600">Create Event</span>
                            </a>

                            <a href="{{ route('events.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-colors duration-200 group">
                                <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-700 group-hover:text-green-600">Browse Events</span>
                            </a>

                            <a href="{{ route('audit-log.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-50 transition-colors duration-200 group">
                                <div class="p-2 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-700 group-hover:text-orange-600">Activity Log</span>
                            </a>

                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors duration-200 group">
                                <div class="p-2 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors">
                                    <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-600">Admin Dashboard</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Account Security Card --}}
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl shadow-lg p-6 text-white">
                        <h4 class="text-lg font-black mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Account Security
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                <span class="text-sm font-medium">Email Verified</span>
                                <span class="flex items-center gap-1 text-sm font-bold">
                                    @if(auth()->user()->email_verified_at)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Yes
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        No
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                <span class="text-sm font-medium">Last Login</span>
                                <span class="text-sm font-bold">{{ auth()->user()->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                <span class="text-sm font-medium">Account Status</span>
                                <span class="text-sm font-bold">Active</span>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Activity Card --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">
                        <h4 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recent Activity
                        </h4>
                        @php
                            $recentActivities = \App\Models\AuditLog::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        @if($recentActivities->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentActivities as $activity)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <div class="p-2 bg-blue-100 rounded-lg flex-shrink-0">
                                        <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->action }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('audit-log.index') }}" class="mt-4 block text-center text-sm font-bold text-blue-600 hover:text-blue-700">
                                View All Activity →
                            </a>
                        @else
                            <p class="text-sm text-gray-500 text-center py-4">No recent activity</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
