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
                        Payment Details
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                    <p class="text-white/70 mt-2">View detailed information about this payment</p>
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
                                Payment #{{ $payment->id }}
                            </h3>
                            <p class="text-white/70 text-lg">Amount: ${{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('payments.edit', $payment) }}"
                               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                      text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                      hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Edit Payment
                            </a>
                            <a href="{{ route('payments.index') }}"
                               class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700
                                      text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-gray-500/30
                                      hover:shadow-xl hover:shadow-gray-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Back to Payments
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Payment Information -->
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-purple-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-black text-white">Payment Information</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Amount:</span>
                                    <span class="text-white font-bold">${{ number_format($payment->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Payment Method:</span>
                                    <span class="text-white font-bold">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Payment Date:</span>
                                    <span class="text-white font-bold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Created:</span>
                                    <span class="text-white font-bold">{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M d, Y H:i') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Information -->
                        @if($payment->booking)
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-green-500/20 rounded-xl">
                                    <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-black text-white">Booking Information</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Booking ID:</span>
                                    <span class="text-white font-bold">{{ $payment->booking->id }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Event:</span>
                                    <span class="text-white font-bold">{{ $payment->booking->event->name ?? 'Unknown Event' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Ticket Type:</span>
                                    <span class="text-white font-bold">{{ $payment->booking->ticket->type ?? 'Unknown Ticket' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/10">
                                    <span class="text-white/70 font-semibold">Quantity:</span>
                                    <span class="text-white font-bold">{{ $payment->booking->quantity ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Delete Button -->
                    <div class="mt-8 flex justify-end">
                        <form method="POST" action="{{ route('payments.destroy', $payment) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700
                                           text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-red-500/30
                                           hover:shadow-xl hover:shadow-red-500/50 transition-all duration-300 hover:scale-105 active:scale-95"
                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                Delete Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
