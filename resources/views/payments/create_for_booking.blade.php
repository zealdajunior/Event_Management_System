<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment - Book Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Booking Summary -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Booking Summary</h3>
                        
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Event Info -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Event</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $booking->event->name }}</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ $booking->event->date ? \Carbon\Carbon::parse($booking->event->date)->format('M d, Y H:i') : 'N/A' }}
                                    </p>
                                </div>

                                <!-- Ticket Info -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Ticket Type</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $booking->ticket->type }}</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Quantity: <span class="font-semibold">{{ $booking->ticket->quantity }}</span>
                                    </p>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Amount</p>
                                    <p class="text-2xl font-bold text-blue-600">${{ number_format($booking->ticket->price, 2) }}</p>
                                </div>

                                <!-- User Info -->
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Attendee</p>
                                    <p class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-600 mt-2">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Choose Payment Method</h3>

                        <form action="{{ route('payments.store') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                            <div class="space-y-4">
                                @foreach($paymentMethods as $method)
                                    <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-200"
                                           for="method-{{ $method['id'] }}">
                                        <input type="radio" 
                                               name="payment_method" 
                                               value="{{ $method['id'] }}" 
                                               id="method-{{ $method['id'] }}"
                                               class="w-4 h-4 text-blue-600"
                                               {{ $loop->first ? 'checked' : '' }}>
                                        <div class="ml-4 flex-1">
                                            <p class="text-lg font-semibold text-gray-900">{{ $method['name'] }}</p>
                                            <p class="text-sm text-gray-600">{{ $method['description'] }}</p>
                                        </div>
                                        <div class="p-2 bg-white rounded-lg">
                                            @if($method['icon'] === 'credit-card')
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            @elseif($method['icon'] === 'stripe')
                                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M13.976 9.15c-2.172-.806-3.356-1.629-3.356-2.76 0-.55.446-.960 1.084-.960.679 0 1.891.248 2.693.905.859-.035 1.671-.27 2.157-.693a4.811 4.811 0 001.284-1.384c.456.688.906 1.444.1447 2.32.405.41.763.894 1.052 1.427.748-.368 1.653-.823 2.479-1.580a5.902 5.902 0 00-1.364-1.579 4.17 4.17 0 00-2.814-.946c-1.405 0-2.782.808-3.7 2.106-.915 1.297-1.262 3.01-.62 4.625"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Error Messages -->
                            @if($errors->any())
                                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-800 font-semibold mb-2">Error:</p>
                                    <ul class="list-disc list-inside space-y-1 text-red-700">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="mt-8 flex gap-4">
                                <a href="@dashboardRoute" 
                                   class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Process Payment
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-green-900">Secure Payment</p>
                            <p class="text-sm text-green-700 mt-1">Your payment information is encrypted and secure. We use industry-standard SSL encryption to protect your data.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
