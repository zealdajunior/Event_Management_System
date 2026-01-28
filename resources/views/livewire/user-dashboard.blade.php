<div class="min-h-screen bg-gray-900">
    {{-- ================= HEADER ================= --}}
    <div class="bg-gray-800 border-b border-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-7">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-black">Dashboard</h1>
                        <p class="text-sm text-black">Welcome back! Here's your event overview</p>
                    </div>
                </div>

                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-2 text-sm text-gray-400">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-black">Live</span>
                    </div>

                    <a href="{{ route('event-requests.create') }}"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Request Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= PAGE CONTAINER ================= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- ================= STATS OVERVIEW ================= --}}
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-sm p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Upcoming Events -->
                <div class="bg-gradient-to-br from-blue-900/40 to-blue-800/40 p-6 rounded-lg border border-blue-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-400">Upcoming Events</p>
                            <p class="text-2xl font-bold text-white">{{ $upcomingEventsCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Attendees -->
                <div class="bg-gradient-to-br from-green-900/40 to-green-800/40 p-6 rounded-lg border border-green-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-400">Total Attendees</p>
                            <p class="text-2xl font-bold text-white">{{ $totalAttendees }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/40 p-6 rounded-lg border border-purple-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-400">Total Revenue</p>
                            <p class="text-2xl font-bold text-white">${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- My Bookings -->
                <div class="bg-gradient-to-br from-orange-900/40 to-orange-800/40 p-6 rounded-lg border border-orange-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-400">My Bookings</p>
                            <p class="text-2xl font-bold text-white">{{ $myBookings->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= AVAILABLE EVENTS ================= --}}
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-sm p-8 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Available Events</h2>
                <div class="flex space-x-4">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search events..."
                           class="px-4 py-2 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <select wire:model.live="categoryFilter" class="px-4 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="typeFilter" class="px-4 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="free">Free Events</option>
                        <option value="paid">Paid Events</option>
                    </select>
                </div>
            </div>

            @if($availableEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableEvents as $event)
                        <div class="bg-gray-700 border border-gray-600 rounded-lg shadow hover:shadow-lg hover:border-green-500 transition-all duration-200 overflow-hidden">
                            {{-- Event Image/Visual --}}
                            <div class="bg-gradient-to-br from-green-600 to-teal-600 h-32 flex items-center justify-center relative overflow-hidden">
                                @if($event->category)
                                    <div class="absolute inset-0 opacity-20">
                                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                    </div>
                                @endif
                                <span class="text-white font-bold text-3xl relative z-10">{{ strtoupper(substr($event->name, 0, 1)) }}</span>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-white mb-2">{{ $event->name }}</h3>
                                        <p class="text-sm text-gray-300 mb-3 line-clamp-2">{{ $event->description }}</p>

                                        <div class="space-y-2 text-sm text-gray-400">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($event->date)->format('M j, Y') }}
                                                @if($event->end_date)
                                                    - {{ \Carbon\Carbon::parse($event->end_date)->format('M j, Y') }}
                                                @endif
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->venue->name ?? 'TBD' }}
                                            </div>
                                            @if($event->price && $event->price > 0)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                    ${{ number_format($event->price, 2) }}
                                                </div>
                                            @else
                                                <div class="flex items-center text-green-400">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                    Free Event
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('events.show', $event) }}"
                                       class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200 text-center">
                                        View Details
                                    </a>
                                    @if($event->price && $event->price > 0)
                                        <a href="{{ route('bookings.create', ['event' => $event->id]) }}"
                                           class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors duration-200 text-center">
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('bookings.create', ['event' => $event->id]) }}"
                                           class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors duration-200 text-center">
                                            Register
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No events found</h3>
                    <p class="mt-1 text-sm text-gray-400">Try adjusting your search or filters.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY BOOKINGS ================= --}}
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold text-white mb-6">My Bookings</h2>

            @if($myBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($myBookings as $booking)
                        <div class="border border-gray-700 rounded-lg p-4 bg-gray-700/50 hover:bg-gray-700 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white">{{ $booking->event->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $booking->event->description }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-400">
                                        <span>{{ \Carbon\Carbon::parse($booking->event->date)->format('M j, Y') }}</span>
                                        <span>{{ $booking->event->venue->name ?? 'TBD' }}</span>
                                        <span class="px-2 py-1 bg-green-900/40 text-green-400 rounded-full text-xs">{{ $booking->status }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-500 transition-colors duration-200">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No bookings yet</h3>
                    <p class="mt-1 text-sm text-gray-400">Start by booking an event above.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY TICKETS ================= --}}
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold text-white mb-6">My Tickets</h2>

            @if($myTickets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($myTickets as $ticket)
                        <div class="border border-blue-700/50 rounded-lg p-4 bg-gradient-to-br from-blue-900/40 to-blue-800/40">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-white">{{ $ticket->event->name }}</h3>
                                <span class="px-2 py-1 bg-blue-700/40 text-blue-300 rounded-full text-xs">{{ $ticket->type }}</span>
                            </div>
                            <p class="text-sm text-gray-400 mb-2">{{ $ticket->event->description }}</p>
                            <div class="text-sm text-gray-400">
                                <p>{{ \Carbon\Carbon::parse($ticket->event->date)->format('M j, Y') }}</p>
                                <p>{{ $ticket->event->venue->name ?? 'TBD' }}</p>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-300">Ticket #{{ $ticket->id }}</span>
                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v-3a2 2 0 00-2-2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No tickets yet</h3>
                    <p class="mt-1 text-sm text-gray-400">Your tickets will appear here after booking events.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY PAYMENTS ================= --}}
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-sm p-8">
            <h2 class="text-xl font-bold text-white mb-6">My Payments</h2>

            @if($myPayments->count() > 0)
                <div class="space-y-4">
                    @foreach($myPayments as $payment)
                        <div class="border border-gray-700 rounded-lg p-4 bg-gray-700/50 hover:bg-gray-700 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white">{{ $payment->booking->event->name ?? 'Event' }}</h3>
                                    <p class="text-sm text-gray-400">{{ $payment->booking->event->description ?? '' }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-400">
                                        <span>{{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y') }}</span>
                                        <span class="px-2 py-1 bg-green-900/40 text-green-400 rounded-full text-xs">{{ $payment->status }}</span>
                                        <span class="px-2 py-1 bg-blue-900/40 text-blue-400 rounded-full text-xs">{{ $payment->method }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="text-lg font-bold text-green-400">${{ number_format($payment->amount, 2) }}</span>
                                    <a href="{{ route('payments.show', $payment) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-500 transition-colors duration-200">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No payments yet</h3>
                    <p class="mt-1 text-sm text-gray-400">Your payment history will appear here after making transactions.</p>
                </div>
            @endif
        </div>
    </div>
</div>
                                            @if($event->price && $event->price > 0)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                    ${{ number_format($event->price, 2) }}
                                                </div>
                                            @else
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                    Free Event
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('events.show', $event) }}"
                                       class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors duration-200 text-center">
                                        View Details
                                    </a>
                                    @if($event->price && $event->price > 0)
                                        <a href="{{ route('bookings.create', ['event' => $event->id]) }}"
                                           class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200 text-center">
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('bookings.create', ['event' => $event->id]) }}"
                                           class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors duration-200 text-center">
                                            Register
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No events found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY BOOKINGS ================= --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">My Bookings</h2>

            @if($myBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($myBookings as $booking)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $booking->event->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $booking->event->description }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ \Carbon\Carbon::parse($booking->event->date)->format('M j, Y') }}</span>
                                        <span>{{ $booking->event->venue->name ?? 'TBD' }}</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $booking->status }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors duration-200">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start by booking an event above.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY TICKETS ================= --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6">My Tickets</h2>

            @if($myTickets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($myTickets as $ticket)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gradient-to-br from-blue-50 to-blue-100">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $ticket->event->name }}</h3>
                                <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs">{{ $ticket->type }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $ticket->event->description }}</p>
                            <div class="text-sm text-gray-500">
                                <p>{{ \Carbon\Carbon::parse($ticket->event->date)->format('M j, Y') }}</p>
                                <p>{{ $ticket->event->venue->name ?? 'TBD' }}</p>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-900">Ticket #{{ $ticket->id }}</span>
                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="text-slate-900 hover:text-slate-900 text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v-3a2 2 0 00-2-2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Your tickets will appear here after booking events.</p>
                </div>
            @endif
        </div>

        {{-- ================= MY PAYMENTS ================= --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">My Payments</h2>

            @if($myPayments->count() > 0)
                <div class="space-y-4">
                    @foreach($myPayments as $payment)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $payment->booking->event->name ?? 'Event' }}</h3>
                                    <p class="text-sm text-gray-600">{{ $payment->booking->event->description ?? '' }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y') }}</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $payment->status }}</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $payment->method }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="text-lg font-bold text-green-600">${{ number_format($payment->amount, 2) }}</span>
                                    <a href="{{ route('payments.show', $payment) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors duration-200">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payments yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Your payment history will appear here after making transactions.</p>
                </div>
            @endif
        </div>
    </div>
</div>
