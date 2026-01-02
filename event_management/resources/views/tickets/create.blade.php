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
                        Create New Ticket
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Fill in the details to create a new ticket</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Event Selection -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Event Selection</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div>
                                    <x-input-label for="event_id" :value="__('Event')" class="text-white font-semibold" />
                                    <select id="event_id" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="event_id" required>
                                        <option value="" class="bg-gray-800">Select an event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }} class="bg-gray-800">{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('event_id')" class="mt-2 text-red-300" />
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-pink-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Ticket Details</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="type" :value="__('Ticket Type')" class="text-white font-semibold" />
                                        <x-text-input id="type" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="text" name="type" :value="old('type')" required autofocus autocomplete="type" placeholder="e.g., General, VIP, Early Bird" />
                                        <x-input-error :messages="$errors->get('type')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="price" :value="__('Price ($)')" class="text-white font-semibold" />
                                        <x-text-input id="price" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="number" step="0.01" name="price" :value="old('price')" required min="0" placeholder="0.00 for free tickets" />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2 text-red-300" />
                                    </div>

                                    <div>
                                        <x-input-label for="quantity" :value="__('Quantity')" class="text-white font-semibold" />
                                        <x-text-input id="quantity" class="block mt-1 w-full bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-purple-400 focus:ring-purple-400 rounded-xl" type="number" name="quantity" :value="old('quantity')" required min="1" placeholder="Number of tickets available" />
                                        <x-input-error :messages="$errors->get('quantity')" class="mt-2 text-red-300" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                {{ __('Create Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
