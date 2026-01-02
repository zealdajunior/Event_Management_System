<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl border border-white/10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Event Details
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Complete information about this event</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <div class="mb-8">
                        <h3 class="text-4xl font-black text-white mb-6">{{ $event->name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-purple-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Description</h4>
                                </div>
                                <p class="text-white/70 leading-relaxed">{{ $event->description ?: 'No description provided.' }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-pink-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Date & Time</h4>
                                </div>
                                <p class="text-white/70 text-lg">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y \a\t g:i A') : 'N/A' }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-green-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Location</h4>
                                </div>
                                <p class="text-white/70">{{ $event->location }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-blue-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Venue</h4>
                                </div>
                                <p class="text-white/70">{{ $event->venue ? $event->venue->name : 'N/A' }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-yellow-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Status</h4>
                                </div>
                                <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full {{ $event->status == 'active' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-indigo-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Created By</h4>
                                </div>
                                <p class="text-white/70">{{ $event->user ? $event->user->name : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-start gap-4 mt-8">
                        @auth
                            <form method="POST" action="{{ route('favorites.toggle', $event) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="group relative {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:from-red-600 hover:via-red-700 hover:to-red-800 shadow-red-500/30 hover:shadow-red-500/50' : 'bg-gradient-to-r from-yellow-500 via-orange-600 to-red-600 hover:from-yellow-600 hover:via-orange-700 hover:to-red-700 shadow-yellow-500/30 hover:shadow-yellow-500/50' }}
                                               active:scale-95 transition-all duration-300
                                               text-white px-6 py-3 rounded-2xl font-bold shadow-lg
                                               hover:shadow-xl flex items-center gap-3">
                                    <svg class="w-5 h-5 {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'group-hover:scale-110' : 'group-hover:animate-pulse' }} transition-transform duration-300" fill="{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                                </button>
                            </form>
                        @endauth
                        <a href="{{ route('events.index') }}"
                           class="group relative bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800
                                  active:scale-95 transition-all duration-300
                                  text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-gray-500/30
                                  hover:shadow-xl hover:shadow-gray-500/50 flex items-center gap-3">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Events</span>
                        </a>
                        <a href="{{ route('events.edit', $event) }}"
                           class="group relative bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800
                                  active:scale-95 transition-all duration-300
                                  text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                  hover:shadow-xl hover:shadow-blue-500/50 flex items-center gap-3">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit Event</span>
                        </a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="group relative bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:from-red-600 hover:via-red-700 hover:to-red-800
                                           active:scale-95 transition-all duration-300
                                           text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-red-500/30
                                           hover:shadow-xl hover:shadow-red-500/50 flex items-center gap-3"
                                    onclick="return confirm('Are you sure you want to delete this event?')">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Delete Event</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
