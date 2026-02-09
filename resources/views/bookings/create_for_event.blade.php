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
                        Book Tickets for {{ $event->name }}
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">Select your ticket type and complete your booking</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <!-- Ticket Selection -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">Select Ticket Type</h3>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                                @if($event->tickets->count() > 0)
                                    <div>
                                        <x-input-label for="ticket_id" :value="__('Available Tickets')" class="text-white font-semibold" />
                                        <select id="ticket_id" class="block mt-1 w-full bg-white/10 border-white/20 text-white focus:border-purple-400 focus:ring-purple-400 rounded-xl" name="ticket_id" required>
                                            <option value="" class="bg-gray-800">Choose a ticket type</option>
                                            @foreach($event->tickets as $ticket)
                                                @if($ticket->quantity > 0)
                                                    <option value="{{ $ticket->id }}" class="bg-gray-800">
                                                        {{ $ticket->type }} - ${{ number_format($ticket->price, 2) }} ({{ $ticket->quantity }} available)
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('ticket_id')" class="mt-2 text-red-300" />
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-500/20 mb-4">
                                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-white mb-2">No Tickets Available</h3>
                                        <p class="text-white/70 mb-4">This event doesn't have any ticket types yet.</p>
                                        @if(Auth::id() === $event->user_id)
                                            <a href="{{ route('tickets.create') }}?event_id={{ $event->id }}" 
                                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Create Tickets
                                            </a>
                                        @else
                                            <p class="text-white/60 text-sm">Please contact the event organizer to create tickets.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                {{ __('Book Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
