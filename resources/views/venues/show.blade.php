 <x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl border border-white/10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Venue Details
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Complete information about this venue</p>
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
                        <h3 class="text-4xl font-black text-white mb-6">{{ $venue->name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-purple-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Address</h4>
                                </div>
                                <p class="text-white/70 leading-relaxed">{{ $venue->address }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-pink-500/20 rounded-xl">
                                        <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-white text-lg">Capacity</h4>
                                </div>
                                <p class="text-white/70 text-lg">{{ $venue->capacity }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-start gap-4 mt-8">
                        <a href="{{ route('venues.index') }}"
                           class="group relative bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800
                                  active:scale-95 transition-all duration-300
                                  text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-gray-500/30
                                  hover:shadow-xl hover:shadow-gray-500/50 flex items-center gap-3">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Venues</span>
                        </a>
                        <a href="{{ route('venues.edit', $venue) }}"
                           class="group relative bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800
                                  active:scale-95 transition-all duration-300
                                  text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                  hover:shadow-xl hover:shadow-blue-500/50 flex items-center gap-3">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit Venue</span>
                        </a>
                        <form method="POST" action="{{ route('venues.destroy', $venue) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="group relative bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:from-red-600 hover:via-red-700 hover:to-red-800
                                           active:scale-95 transition-all duration-300
                                           text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-red-500/30
                                           hover:shadow-xl hover:shadow-red-500/50 flex items-center gap-3"
                                    onclick="return confirm('Are you sure you want to delete this venue?')">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Delete Venue</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
