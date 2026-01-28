<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl border border-white/10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Ticket Details
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">View detailed information about this ticket</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                <div class="relative p-8">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-3xl font-black text-white mb-2">
                                {{ $ticket->type }} Ticket
                            </h3>
                            <p class="text-white/70 text-lg">For {{ $ticket->event ? $ticket->event->name : 'Unknown Event' }}</p>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('tickets.edit', $ticket) }}"
                               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                      text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                      hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Edit Ticket
                            </a>
                            <a href="{{ route('tickets.index') }}"
                               class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700
                                      text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-gray-500/30
                                      hover:shadow-xl hover:shadow-gray-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Back to Tickets
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Ticket Information -->
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-black text-white">Ticket Information</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Ticket Type:</span>
                                    <span class="text-white font-bold">{{ $ticket->type }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Price:</span>
                                    <span class="text-white font-bold">${{ number_format($ticket->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Quantity Available:</span>
                                    <span class="text-white font-bold">{{ $ticket->quantity }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Created:</span>
                                    <span class="text-white font-bold">{{ $ticket->created_at ? \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y H:i') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Event Information -->
                        @if($ticket->event)
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-green-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-black text-white">Event Information</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Event Name:</span>
                                    <span class="text-white font-bold">{{ $ticket->event->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Event Date:</span>
                                    <span class="text-white font-bold">{{ $ticket->event->date ? \Carbon\Carbon::parse($ticket->event->date)->format('M d, Y H:i') : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Location:</span>
                                    <span class="text-white font-bold">{{ $ticket->event->location }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Status:</span>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $ticket->event->status == 'active' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                                        {{ ucfirst($ticket->event->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Delete Button -->
                    <div class="mt-8 flex justify-end">
                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700
                                           text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-red-500/30
                                           hover:shadow-xl hover:shadow-red-500/50 transition-all duration-300 hover:scale-105 active:scale-95"
                                    onclick="return confirm('Are you sure you want to delete this ticket?')">
                                Delete Ticket
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
