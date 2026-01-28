<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-50 to-white rounded-2xl p-4 mb-6 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-900">
                        Event Details
                    </h2>
                    <div class="h-1 w-20 bg-blue-500 rounded-full mt-1"></div>
                    <p class="text-gray-600 mt-1 text-sm">Complete information about this event</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-2xl shadow-xl overflow-hidden">
                <div class="relative p-6">
                    <!-- Event Title -->
                    <div class="mb-8">
                        <div class="flex justify-center mb-6">
                            <div class="bg-white px-6 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <h3 class="text-3xl font-black text-gray-900 text-center">{{ $event->name }}</h3>
                            </div>
                        </div>
                        
                        <!-- Event Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Description -->
                            <div class="lg:col-span-3 bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                            <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-lg">Description</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl">
                                    <p class="text-gray-700 leading-relaxed text-sm">{{ $event->description ?: 'No description provided.' }}</p>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="bg-white rounded-2xl p-5 border border-blue-200 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <rect x="3" y="5" width="18" height="16" rx="2" stroke-linecap="round"/>
                                            <path d="M3 9h18M7 3v4M17 3v4" stroke-linecap="round"/>
                                            <circle cx="12" cy="15" r="3.5"/>
                                            <path d="M12 13.5v2l1.5 1" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Date & Time</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 text-sm font-bold">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y') : 'N/A' }}</p>
                                    @if($event->date)
                                        <p class="text-blue-600 text-xs font-semibold mt-1">{{ \Carbon\Carbon::parse($event->date)->format('g:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                            <circle cx="12" cy="9" r="3" fill="white" opacity="0.9"/>
                                            <path d="M12 20c-1 0-2-.5-2-1s1-1 2-1 2 .5 2 1-1 1-2 1z" opacity="0.6"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Location</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm">{{ $event->location }}</p>
                                </div>
                            </div>

                            <!-- Venue -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 21h18" stroke-linecap="round"/>
                                            <path d="M4 21V8l8-5 8 5v13" stroke-linecap="round" stroke-linejoin="round"/>
                                            <rect x="9" y="12" width="6" height="5" fill="currentColor" opacity="0.5"/>
                                            <path d="M7 11h2M15 11h2M7 15h2M15 15h2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Venue</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm">{{ $event->venue ? $event->venue->name : 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <path d="M3 12h4l3-9 4 18 3-9h4" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Status</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl flex justify-center">
                                    @if(strtolower($event->status) == 'active')
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-black rounded-xl bg-blue-500 text-white shadow-md">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-black rounded-xl bg-gray-400 text-white shadow-md">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="8" r="4" fill="currentColor" opacity="0.8"/>
                                            <path d="M4 20c0-4 3.5-7 8-7s8 3 8 7" stroke-linecap="round"/>
                                            <path d="M16 6l2-2M8 6L6 4" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Created By</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm">{{ $event->user ? $event->user->name : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="my-6">
                        <div class="h-px bg-gradient-to-r from-transparent via-blue-300 to-transparent"></div>
                    </div>

                    <!-- Media Gallery -->
                    <div class="mb-8">
                        <x-event-media-gallery :event="$event" />
                    </div>

                    <!-- Divider -->
                    <div class="my-6">
                        <div class="h-px bg-gradient-to-r from-transparent via-blue-300 to-transparent"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        @auth
                            <form method="POST" action="{{ route('favorites.toggle', $event) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="group relative {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-blue-50 hover:bg-blue-100 text-blue-600' }}
                                               active:scale-95 transition-all duration-300
                                               px-5 py-2.5 rounded-xl font-bold text-sm
                                               shadow-md hover:shadow-lg
                                               flex items-center gap-2">
                                    <svg class="w-4 h-4 {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'group-hover:scale-110' : 'group-hover:animate-pulse' }} transition-transform duration-300" fill="{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                                </button>
                            </form>
                        @endauth
                        <a href="{{ route('user.dashboard') }}"
                           class="group relative bg-blue-50 hover:bg-blue-100
                                  active:scale-95 transition-all duration-300
                                  text-gray-900 px-5 py-2.5 rounded-xl font-bold text-sm
                                  shadow-md hover:shadow-lg
                                  flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
