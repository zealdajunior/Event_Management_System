<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl border border-white/10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Create New Event
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Fill in the details to create an amazing event</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Basic Information</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="name" :value="__('Event Name')" class="text-white font-semibold" />
                                        <x-text-input id="name" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="category" :value="__('Category')" class="text-white font-semibold" />
                                        <select id="category" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="category">
                                            <option value="" class="bg-gray-800">Select a category</option>
                                            <option value="conference" {{ old('category') == 'conference' ? 'selected' : '' }} class="bg-gray-800">Conference</option>
                                            <option value="workshop" {{ old('category') == 'workshop' ? 'selected' : '' }} class="bg-gray-800">Workshop</option>
                                            <option value="concert" {{ old('category') == 'concert' ? 'selected' : '' }} class="bg-gray-800">Concert</option>
                                            <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }} class="bg-gray-800">Sports</option>
                                            <option value="exhibition" {{ old('category') == 'exhibition' ? 'selected' : '' }} class="bg-gray-800">Exhibition</option>
                                            <option value="networking" {{ old('category') == 'networking' ? 'selected' : '' }} class="bg-gray-800">Networking</option>
                                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }} class="bg-gray-800">Other</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-2 text-red-300" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-pink-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Description</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <x-input-label for="description" :value="__('Description')" class="text-white font-semibold" />
                                <textarea id="description" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="description" rows="4" placeholder="Provide a detailed description of the event...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2 text-red-300" />
                            </div>
                        </div>

                        <!-- Date and Time -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-green-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Date and Time</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="date" :value="__('Start Date & Time')" class="text-white font-semibold" />
                                        <x-text-input id="date" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="datetime-local" name="date" :value="old('date')" required />
                                        <x-input-error :messages="$errors->get('date')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="end_date" :value="__('End Date & Time')" class="text-white font-semibold" />
                                        <x-text-input id="end_date" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="datetime-local" name="end_date" :value="old('end_date')" />
                                        <x-input-error :messages="$errors->get('end_date')" class="mt-2 text-red-300" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location and Venue -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-blue-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Location and Venue</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="location" :value="__('Location')" class="text-white font-semibold" />
                                        <x-text-input id="location" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="text" name="location" :value="old('location')" required autocomplete="location" />
                                        <x-input-error :messages="$errors->get('location')" class="mt-2 text-red-300" />
                                    </div>

                                    {{-- <div>
                                        <x-input-label for="venue_id" :value="__('Venue')" class="text-white font-semibold" />
                                        <select id="venue_id" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="venue_id" required>
                                            <option value="" class="bg-gray-800">Select a venue</option>
                                            @foreach($venues as $venue)
                                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }} class="bg-gray-800">{{ $venue->name }}</option>
                                                <option value="public" {{ old('event_type') == 'public' ? 'selected' : '' }} class="bg-gray-800">Public</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('venue_id')" class="mt-2 text-red-300" />
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Capacity and Pricing -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-yellow-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Capacity and Pricing</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="capacity" :value="__('Capacity')" class="text-white font-semibold" />
                                        <x-text-input id="capacity" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="number" name="capacity" :value="old('capacity')" min="1" placeholder="Maximum number of attendees" />
                                        <x-input-error :messages="$errors->get('capacity')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="price" :value="__('Price ($)')" class="text-white font-semibold" />
                                        <x-text-input id="price" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="number" step="0.01" name="price" :value="old('price')" min="0" placeholder="0.00 for free events" />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="event_type" :value="__('Event Type')" class="text-white font-semibold" />
                                        <select id="event_type" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="event_type">
                                            <option value="" class="bg-gray-800">Select event type</option>
                                            <option value="public" {{ old('event_type') == 'public' ? 'selected' : '' }} class="bg-gray-800">Public</option>
                                            <option value="private" {{ old('event_type') == 'private' ? 'selected' : '' }} class="bg-gray-800">Private</option>
                                            <option value="vip" {{ old('event_type') == 'vip' ? 'selected' : '' }} class="bg-gray-800">VIP</option>
                                            <option value="corporate" {{ old('event_type') == 'corporate' ? 'selected' : '' }} class="bg-gray-800">Corporate</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('event_type')" class="mt-2 text-red-300" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organizer Information -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-indigo-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Organizer Information</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="organizer_name" :value="__('Organizer Name')" class="text-white font-semibold" />
                                        <x-text-input id="organizer_name" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="text" name="organizer_name" :value="old('organizer_name')" />
                                        <x-input-error :messages="$errors->get('organizer_name')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="organizer_email" :value="__('Organizer Email')" class="text-white font-semibold" />
                                        <x-text-input id="organizer_email" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="email" name="organizer_email" :value="old('organizer_email')" />
                                        <x-input-error :messages="$errors->get('organizer_email')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="organizer_phone" :value="__('Organizer Phone')" class="text-white font-semibold" />
                                        <x-text-input id="organizer_phone" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="tel" name="organizer_phone" :value="old('organizer_phone')" />
                                        <x-input-error :messages="$errors->get('organizer_phone')" class="mt-2 text-red-300" />
                                    </div>

                                <div>
                                          <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-primary-button class="px-6 py-3 text-lg rounded-xl">
                                {{ __('Create Event') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
