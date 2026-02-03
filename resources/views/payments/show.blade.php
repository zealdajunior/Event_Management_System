<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Receipt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 font-semibold">{{ session('status') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Receipt Header -->
                <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-3xl font-bold text-gray-900">Payment Confirmed</h2>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600">Your payment has been successfully processed</p>
                </div>

                <!-- Receipt Content -->
                <div class="p-6 space-y-8">
                    <!-- Transaction Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-600 mb-1">Transaction ID</p>
                                <p class="text-lg font-mono font-bold text-gray-900 break-all">{{ $payment->transaction_id }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-600 mb-1">Payment Status</p>
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold capitalize">
                                    {{ $payment->status }}
                                </span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-600 mb-1">Payment Method</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-600 mb-1">Payment Date</p>
                                <p class="text-lg font-bold text-gray-900">{{ $payment->payment_date->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Information</h3>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Event -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Event</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $payment->booking->event->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $payment->booking->event->date ? \Carbon\Carbon::parse($payment->booking->event->date)->format('M d, Y H:i') : 'N/A' }}
                                    </p>
                                </div>

                                <!-- Ticket -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Ticket Type</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $payment->booking->ticket->type }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Qty: {{ $payment->booking->ticket->quantity }}
                                    </p>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Total Amount</p>
                                    <p class="text-2xl font-bold text-blue-600">${{ number_format($payment->amount, 2) }}</p>
                                </div>

                                <!-- Attendee -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Attendee</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $payment->booking->user->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $payment->booking->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="font-semibold text-yellow-900 mb-2">📋 Important Notes:</p>
                        <ul class="space-y-1 text-sm text-yellow-800">
                            <li>• A confirmation email has been sent to <span class="font-semibold">{{ $payment->booking->user->email }}</span></li>
                            <li>• Your ticket has been emailed to you as a PDF attachment</li>
                            <li>• Please arrive 15 minutes early on the event day</li>
                            <li>• Bring your ticket (printed or on your phone) to the event</li>
                            <li>• Your booking is confirmed and locked in</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pt-8 border-t border-gray-200">
                        <a href="@dashboardRoute" 
                           class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg text-center">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('bookings.ticket', $payment->booking) }}" 
                           class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg text-center flex items-center justify-center gap-2">
                            🎫 View Ticket
                        </a>
                        <button onclick="window.print()" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 0a2 2 0 100-4 2 2 0 000 4zm0 0a6 6 0 100-12 6 6 0 000 12z"></path>
                            </svg>
                            Print Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

