<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl border border-white/10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Edit Booking
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Update your booking details</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <form method="POST" action="{{ route('bookings.update', $booking) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Event Selection -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Select Event</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div>
                                    <x-input-label for="event_id" :value="__('Event')" class="text-white font-semibold" />
                                    <select id="event_id" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="event_id" required>
                                        <option value="" class="bg-gray-800">Select an event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id', $booking->event_id) == $event->id ? 'selected' : '' }} class="bg-gray-800">{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('event_id')" class="mt-2 text-red-300" />
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Selection -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-pink-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Select Ticket</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                <div>
                                    <x-input-label for="ticket_id" :value="__('Ticket')" class="text-white font-semibold" />
                                    <select id="ticket_id" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="ticket_id" required>
                                        <option value="" class="bg-gray-800">Select a ticket</option>
                                        @foreach($events as $event)
                                            @foreach($event->tickets as $ticket)
                                                <option value="{{ $ticket->id }}" {{ old('ticket_id', $booking->ticket_id) == $ticket->id ? 'selected' : '' }} class="bg-gray-800">
                                                    {{ $ticket->type }} - ${{ number_format($ticket->price, 2) }} ({{ $ticket->quantity }} available)
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('ticket_id')" class="mt-2 text-red-300" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('bookings.show', $booking) }}"
                               class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700
                                      text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-gray-500/30
                                      hover:shadow-xl hover:shadow-gray-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Cancel
                            </a>
                            <x-primary-button class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                {{ __('Update Booking') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
