<x-app-layout>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-black">Dashboard</h1>
                            <p class="text-sm text-gray-900">Welcome back! Here's your event overview</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 text-sm text-blue-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span>Live</span>
                        </div>

                        <a href="{{ route('events.create.user') }}"
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Event
                        </a>

                        <a href="{{ route('event-requests.create') }}"
                           class="inline-flex items-center px-5 py-2.5 border-2 border-blue-500 text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 transition-all duration-300 shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Request Approval
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= PAGE CONTAINER ================= --}}
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= STATS OVERVIEW ================= --}}
            <div class="bg-gradient-to-r from-white to-blue-50 rounded-2xl shadow-sm border border-blue-50 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                    $stats = [
                        ['label' => 'Upcoming Events', 'value' => $upcomingEventsCount, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Total Attendees', 'value' => $totalAttendees, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Revenue', 'value' => '$'.number_format($totalRevenue,2), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Notifications', 'value' => $notificationsCount, 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600']
                    ];
                    @endphp

                    @foreach($stats as $stat)
                    <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-black mb-1">{{ $stat['label'] }}</p>
                                <p class="text-3xl font-bold text-black">{{ $stat['value'] }}</p>
                            </div>
                            <div class="p-3 rounded-lg {{ $stat['bgColor'] }} group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 {{ $stat['textColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 bg-gradient-to-r from-{{ $stat['color'] }}-200 to-{{ $stat['color'] }}-300 rounded-full"></div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= PERSONALIZED RECOMMENDATIONS ================= --}}
            @if($recommendedEvents && $recommendedEvents->count() > 0)
            <div class="bg-gradient-to-br from-purple-50 via-white to-pink-50 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-black">Just For You</h3>
                        <p class="text-sm text-gray-600">Based on your interests</p>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($recommendedEvents as $event)
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-purple-100 flex flex-col" style="height: 520px;">
                        <div class="flex justify-end mb-3" style="height: 28px;">
                            <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full">✨ Recommended</span>
                        </div>
                        
                        <h4 class="font-black text-xl text-gray-900 leading-tight line-clamp-2 mb-3" style="height: 56px;">{{ $event->name }}</h4>
                        
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">{{ $event->description }}</p>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 50px;">
                            <div class="flex items-center gap-2 text-sm text-gray-700 mb-2" style="height: 20px;">
                                <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'TBD' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700" style="height: 20px;">
                                <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->venue->name ?? 'TBD' }}</span>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 1px;">
                            <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
                        </div>
                        
                        <div class="flex flex-col gap-2 mt-auto flex-shrink-0">
                            <a href="{{ route('bookings.create.for.event', $event) }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                                </svg>
                                Book Now
                            </a>
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-purple-400 hover:bg-purple-50 text-gray-900 font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ================= TRENDING EVENTS ================= --}}
            @if($trendingEvents && $trendingEvents->count() > 0)
            <div class="bg-gradient-to-br from-orange-50 via-white to-red-50 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-black">Trending Now 🔥</h3>
                        <p class="text-sm text-gray-600">Most popular events</p>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($trendingEvents as $event)
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-orange-100 flex flex-col" style="height: 520px;">
                        <div class="flex justify-end mb-3" style="height: 28px;">
                            <div class="flex items-center gap-2">
                                <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 Hot</span>
                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-bold">{{ $event->bookings_count }} bookings</span>
                            </div>
                        </div>
                        
                        <h4 class="font-black text-xl text-gray-900 leading-tight line-clamp-2 mb-3" style="height: 56px;">{{ $event->name }}</h4>
                        
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">{{ $event->description }}</p>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 50px;">
                            <div class="flex items-center gap-2 text-sm text-gray-700 mb-2" style="height: 20px;">
                                <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'TBD' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700" style="height: 20px;">
                                <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->venue->name ?? 'TBD' }}</span>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 1px;">
                            <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
                        </div>
                        
                        <div class="flex flex-col gap-2 mt-auto flex-shrink-0">
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </a>
                            <a href="{{ route('bookings.create.for.event', $event) }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-orange-400 hover:bg-orange-50 text-gray-900 font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
            @endif

            {{-- ================= FUN USER STATS ================= --}}
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 shadow-xl text-white">
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-black mb-2">Your Journey 🎉</h3>
                    <p class="text-blue-100">Member since {{ $userStats['member_since'] }}</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <div class="text-4xl font-black mb-2">{{ $userStats['events_attended'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Events Booked</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <div class="text-4xl font-black mb-2">{{ $userStats['upcoming_bookings'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Upcoming</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <div class="text-4xl font-black mb-2">{{ $userStats['favorites_count'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Favorites</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <div class="text-4xl font-black mb-2">{{ count(auth()->user()->interests ?? []) }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Interests</div>
                    </div>
                </div>
            </div>

            {{-- ================= TAB NAVIGATION ================= --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                $tabs = [
                    'events' => ['label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    'tickets' => ['label' => 'Tickets', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                    'favorites' => ['label' => 'Favorites', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    'calendar' => ['label' => 'Calendar', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2']
                ];
                @endphp

                @foreach($tabs as $key => $tab)
                <a href="#{{ $key }}" data-tab="{{ $key }}"
                   class="tab-link py-5 px-6 text-center rounded-2xl font-bold text-gray-700
                          bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-purple-50
                          border border-gray-200 hover:border-blue-300
                          transition-all duration-300 hover:shadow-lg hover:-translate-y-1
                          flex flex-col items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                    </svg>
                    <span class="text-sm">{{ $tab['label'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- ================= EVENTS TAB ================= --}}
            <div id="events-tab" class="tab-content animate-fadeIn">
                {{-- ================= FEATURED EVENTS ================= --}}
                @if($featuredEvents->count())
            <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50 animate-fadeInUp animate-on-scroll">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-black">
                        Featured Events
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredEvents as $event)
            <div class="group relative animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="absolute inset-0 bg-gradient-to-r from-sky-200 to-blue-200 rounded-3xl blur-xl opacity-15 group-hover:opacity-35 transition-opacity duration-500"></div>
                <div class="relative bg-white border border-blue-50 rounded-3xl p-6
                                    hover:shadow-2xl hover:-translate-y-2 group-hover:shadow-2xl group-hover:-translate-y-2
                                    transition-all duration-500 overflow-hidden">

                            <div class="absolute top-4 right-4 animate-pulse-slow">
                                <span class="bg-gradient-to-r from-sky-500 to-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    ⭐ Featured
                                </span>
                            </div>

                            <h4 class="text-xl text-black mb-3 pr-20 leading-tight font-bold
                                       group-hover:text-blue-600 transition-colors duration-300">
                                {{ $event->name }}
                            </h4>

                            <p class="text-sm text-gray-900 leading-relaxed mb-4 line-clamp-2">
                                {{ Str::limit($event->description, 80) }}
                            </p>

                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-sm text-black group-hover:translate-x-1 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-black group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
                                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $event->venue->name ?? 'TBD' }}</span>
                                </div>
                            </div>

                            <a href="{{ route('events.show', $event) }}"
                               class="inline-flex items-center gap-2 w-full justify-center
                                      bg-white border-2 border-blue-500 hover:bg-blue-50
                                      text-black px-6 py-3.5 rounded-xl font-bold
                                      transform group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-300 
                                      shadow-[0_4px_14px_rgba(59,130,246,0.35)] hover:shadow-[0_8px_24px_rgba(59,130,246,0.45)]">
                                View Details
                                <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ================= SEARCH & FILTER ================= --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-blue-50 animate-fadeIn">
                <form method="GET" action="{{ route('user.dashboard') }}"
                      class="flex flex-col lg:flex-row gap-4">

                    <div class="flex-1 relative group">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-sky-400 group-focus-within:text-sky-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search"
                               value="{{ $currentSearch }}"
                               placeholder="Search events by name, description, or venue..."
                               class="w-full pl-12 pr-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                      focus:ring-4 focus:ring-sky-100 focus:border-blue-200 placeholder-slate-400 text-black
                                      transition-all duration-300 text-sm">
                    </div>

                    <select name="category"
                            class="px-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                   focus:ring-4 focus:ring-sky-100 focus:border-blue-200 text-black
                                   transition-all duration-300 text-sm font-medium hover:border-blue-200">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $category)
                        <option value="{{ $category }}" {{ $currentCategory==$category?'selected':'' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>

                    <select name="type"
                            class="px-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                   focus:ring-4 focus:ring-sky-100 focus:border-blue-200 text-black
                                   transition-all duration-300 text-sm font-medium hover:border-blue-200">
                        <option value="">All Types</option>
                        <option value="free" {{ $currentType=='free'?'selected':'' }}>Free Events</option>
                        <option value="paid" {{ $currentType=='paid'?'selected':'' }}>Paid Events</option>
                    </select>

                    <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                   active:scale-95 transition-all duration-300
                                   text-white px-8 py-4 rounded-xl font-bold 
                                   shadow-[0_4px_14px_rgba(59,130,246,0.4)] hover:shadow-[0_8px_24px_rgba(59,130,246,0.5)]
                                   flex items-center justify-center gap-2 hover:gap-3 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>

                    @if($currentSearch || $currentCategory || $currentType)
                    <a href="{{ route('user.dashboard') }}"
                       class="bg-purple-700/50 hover:bg-purple-600/50 text-purple-100 border border-purple-500/30
                              px-6 py-4 rounded-xl font-bold transition-all duration-300
                              flex items-center justify-center gap-2 backdrop-blur-sm hover:scale-105 hover:-translate-y-0.5
                              shadow-[0_4px_12px_rgba(126,34,206,0.3)] hover:shadow-[0_8px_20px_rgba(126,34,206,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                    @endif
                </form>
            </div>

            <div class="mb-10">
                <h3 class="text-4xl font-black text-gray-900 text-center tracking-tight">
                    Available Events
                </h3>
            </div>
                
            <!-- ADD YOUR EVENTS LISTING HERE -->
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($availableEvents as $event)
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 animate-fadeInUp flex flex-col" style="animation-delay: {{ $loop->index * 0.1 }}s; height: 520px;">
                    
                    <!-- Status Badge -->
                    <div class="flex justify-end mb-3" style="height: 28px;">
                        @if(strtolower($event->status ?? 'active') == 'active')
                            <span class="bg-green-400 text-black px-4 py-1.5 rounded-full text-xs font-bold">
                                Available
                            </span>
                        @else
                            <span class="bg-red-400 text-black px-4 py-1.5 rounded-full text-xs font-bold">
                                Unavailable
                            </span>
                        @endif
                    </div>

                    <!-- Event Title -->
                    <h4 class="text-xl text-gray-900 font-bold leading-tight line-clamp-2 mb-3" style="height: 56px;">
                        {{ $event->name }}
                    </h4>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">
                        {{ $event->description }}
                    </p>

                    <!-- Event Details -->
                    <div class="mb-4 flex-shrink-0" style="height: 50px;">
                        <!-- Date -->
                        <div class="flex items-center gap-2 text-sm text-gray-700 mb-2" style="height: 20px;">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium text-xs truncate">
                                {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        
                        <!-- Venue -->
                        <div class="flex items-center gap-2 text-sm text-gray-700" style="height: 20px;">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium text-xs truncate">{{ $event->venue->name ?? 'TBD' }}</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="mb-4 flex-shrink-0" style="height: 1px;">
                        <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-2 mt-auto flex-shrink-0">
                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center justify-center gap-2
                                  bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                  text-white px-4 py-2.5 rounded-xl font-bold text-sm
                                  shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Details
                        </a>

                        <a href="{{ route('bookings.create.for.event', $event) }}"
                           class="inline-flex items-center justify-center gap-2
                                  bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700
                                  text-white px-4 py-2.5 rounded-xl font-bold text-sm
                                  shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                            </svg>
                            Book Now
                        </a>

                        @auth
                        <form method="POST" action="{{ route('favorites.toggle', $event) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2
                                                         bg-white border-2 {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'border-red-400 hover:bg-red-50' : 'border-yellow-400 hover:bg-yellow-50' }}
                                                         text-gray-900 px-4 py-2.5 rounded-xl font-bold text-sm
                                                         shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-4 h-4 {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'text-red-500' : 'text-yellow-500' }}" fill="{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'Remove' : 'Add to Favorites' }}
                            </button>
                        </form>
                        @endauth
                    </div>
            </div>
            @endforeach
            </div>
            </div>
            </div>
            {{-- END EVENTS TAB --}}

            {{-- ================= TICKETS TAB ================= --}}
            <div id="tickets-tab" class="tab-content hidden animate-fadeIn">
                <div class="">
                    <h3 class="text-xl font-bold text-black mb-6">My Tickets ({{ $myTickets->count() }})</h3>
                    
                    @if($myTickets->count() > 0)
                    <div class="space-y-4">
                        @foreach($myTickets as $booking)
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4
                                    border border-blue-50 p-6 rounded-2xl
                                    hover:shadow-lg hover:scale-[1.02] hover:border-blue-200
                                    transition-all duration-500 bg-white
                                    group animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-black mb-1 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $booking->event->name }}
                                </p>
                                <p class="text-sm text-gray-900 mb-1">
                                    Ticket Type: <span class="font-semibold text-black">{{ $booking->ticket->type }}</span>
                                </p>
                                <p class="text-sm text-gray-900">
                                    Booked: {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') : $booking->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-lg
                                             text-sm font-bold shadow-[0_4px_12px_rgba(59,130,246,0.4)] hover:shadow-[0_6px_16px_rgba(59,130,246,0.5)] 
                                             hover:scale-110 transition-all duration-300">
                                    ${{ number_format($booking->ticket->price, 2) }}
                                </span>
                                <span class="text-xs px-3 py-1 rounded-full font-semibold
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <p class="text-gray-600">No tickets purchased yet. <a href="#events" class="text-blue-600 font-bold">Browse events</a> to get started!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================= FAVORITES TAB ================= --}}
            <div id="favorites-tab" class="tab-content hidden animate-fadeIn">
                <div class="">
                    <h3 class="text-xl font-bold text-black">My Favorites</h3>

                    @if($myFavorites->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($myFavorites as $event)
            <div class="group relative animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-white rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                <div class="relative bg-white border border-blue-50 rounded-3xl p-6
                                    hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                    <div class="absolute top-4 right-4 animate-pulse-slow">
                        <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow">
                            ⭐ Favorite
                        </span>
                    </div>

                    <h4 class="text-xl text-black mb-3 pr-20 leading-tight
                               group-hover:text-blue-600 transition-colors duration-300">
                        {{ $event->name }}
                    </h4>

                    <p class="text-sm text-gray-900 leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit($event->description, 80) }}
                    </p>

                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-sm text-black group-hover:translate-x-1 transition-transform duration-300">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">
                                {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-black group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">{{ $event->venue->name ?? 'TBD' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('bookings.create.for.event', $event) }}"
                           class="inline-flex items-center gap-2 w-full justify-center
                                  bg-white border-2 border-green-500 hover:bg-green-50
                                  text-black px-6 py-3.5 rounded-xl font-bold
                                  transform group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-300 
                                  shadow-[0_4px_14px_rgba(34,197,94,0.35)] hover:shadow-[0_8px_24px_rgba(34,197,94,0.45)]">
                            Book Now
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                            </svg>
                        </a>

                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center gap-2 w-full justify-center
                                  bg-white border-2 border-blue-500 hover:bg-blue-50
                                  text-black px-6 py-3.5 rounded-xl font-bold
                                  transform group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-300 
                                  shadow-[0_4px_14px_rgba(59,130,246,0.35)] hover:shadow-[0_8px_24px_rgba(59,130,246,0.45)]">
                            View Details
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="p-6 bg-gradient-to-r from-sky-100/40 to-blue-100/40 rounded-3xl inline-block mb-6 border border-blue-50">
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold text-black mb-2">No Favorites Yet</h4>
                            <p class="text-gray-900 text-lg mb-6">Start adding events to your favorites to see them here</p>
                            <a href="#events"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                      text-white px-8 py-4 rounded-xl font-bold 
                                      shadow-[0_6px_20px_rgba(59,130,246,0.4)] hover:shadow-[0_10px_30px_rgba(59,130,246,0.5)]
                                      transition-all duration-300 hover:scale-105 active:scale-95 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Browse Events</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================= CALENDAR TAB ================= --}}
            <div id="calendar-tab" class="tab-content hidden animate-fadeIn">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Calendar Section -->
                        <div class="lg:col-span-2">
                            <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-2xl p-8 shadow-lg border border-blue-100">
                                <!-- Calendar Header -->
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-3xl font-black text-gray-900" id="calendar-month"></h3>
                                    <div class="flex gap-2">
                                        <button onclick="previousMonth()" class="p-3 bg-white hover:bg-blue-50 text-blue-600 rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg border border-blue-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="goToToday()" class="px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg">
                                            Today
                                        </button>
                                        <button onclick="nextMonth()" class="p-3 bg-white hover:bg-blue-50 text-blue-600 rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg border border-blue-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Day Headers -->
                                <div class="grid grid-cols-7 gap-2 mb-3">
                                    <div class="text-center font-black text-sm text-gray-600 py-3">SUN</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">MON</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">TUE</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">WED</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">THU</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">FRI</div>
                                    <div class="text-center font-black text-sm text-gray-600 py-3">SAT</div>
                                </div>
                                
                                <!-- Calendar Grid -->
                                <div id="calendar" class="grid grid-cols-7 gap-2">
                                    <!-- Calendar will be populated by JavaScript -->
                                </div>

                                <!-- Selected Date Info -->
                                <div id="selected-date-info" class="mt-6 pt-6 border-t border-blue-200">
                                    <p class="text-center text-sm text-gray-500">Click on a date to view events for that day</p>
                                </div>

                                <!-- Legend -->
                                <div class="mt-4 flex items-center justify-center gap-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <span class="text-sm text-gray-600 font-medium">Today / Selected</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-200"></div>
                                        <span class="text-sm text-gray-600 font-medium">Has Events</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Events for Selected Date Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 sticky top-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="p-2 bg-blue-500 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-lg text-gray-900" id="sidebar-title">All Events</h4>
                                </div>
                                <div id="events-list" class="space-y-3 max-h-[600px] overflow-y-auto">
                                    @forelse($availableEvents->sortBy('date')->take(10) as $event)
                                        @if($event->date && \Carbon\Carbon::parse($event->date)->isFuture())
                                        <div class="group p-4 bg-gradient-to-br from-blue-50 to-white hover:from-blue-100 hover:to-blue-50 rounded-xl transition-all duration-300 border border-blue-200 hover:shadow-md" data-event-date="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}">
                                            <div class="flex items-start justify-between mb-2">
                                                <p class="font-bold text-gray-900 text-sm line-clamp-2 flex-1">{{ $event->name }}</p>
                                                <span class="ml-2 px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                                                    {{ \Carbon\Carbon::parse($event->date)->format('M d') }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-600 mb-3">
                                                <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ \Carbon\Carbon::parse($event->date)->format('h:i A') }}</span>
                                            </div>
                                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-xs font-bold group-hover:gap-2 transition-all duration-300">
                                                View Details
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        @endif
                                    @empty
                                        <div class="text-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-gray-600 text-sm">No upcoming events</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= JAVASCRIPT (TAB SWITCHING AND CALENDAR) ================= --}}
    <script>
        // Calendar functionality with event markers and date selection
        let currentDate = new Date();
        let selectedDate = null;
        
        // Get event dates and details from Laravel
        const events = [
            @foreach($availableEvents as $event)
                @if($event->date)
                {
                    date: '{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}',
                    name: '{{ addslashes($event->name) }}',
                    id: '{{ $event->id }}'
                },
                @endif
            @endforeach
        ];

        const userBookings = [
            @foreach($myTickets as $booking)
                @if($booking->event && $booking->event->date)
                {
                    date: '{{ \Carbon\Carbon::parse($booking->event->date)->format('Y-m-d') }}',
                    name: '{{ addslashes($booking->event->name) }}',
                    id: '{{ $booking->event->id }}'
                },
                @endif
            @endforeach
        ];

        function getEventsForDate(dateString) {
            return events.filter(e => e.date === dateString);
        }

        function getBookingsForDate(dateString) {
            return userBookings.filter(b => b.date === dateString);
        }

        function selectDate(dateString) {
            selectedDate = dateString;
            const dateEvents = getEventsForDate(dateString);
            const dateBookings = getBookingsForDate(dateString);
            const totalEvents = dateEvents.length + dateBookings.length;
            
            // Update selected date info
            const dateObj = new Date(dateString + 'T00:00:00');
            const formattedDate = dateObj.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            const infoDiv = document.getElementById('selected-date-info');
            if (totalEvents > 0) {
                infoDiv.innerHTML = `
                    <div class="text-center">
                        <p class="text-lg font-bold text-blue-600 mb-1">${formattedDate}</p>
                        <p class="text-sm text-gray-600">${totalEvents} event${totalEvents > 1 ? 's' : ''} on this date</p>
                    </div>
                `;
            } else {
                infoDiv.innerHTML = `
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-700 mb-1">${formattedDate}</p>
                        <p class="text-sm text-gray-500">No events on this date</p>
                    </div>
                `;
            }
            
            // Update sidebar
            filterEventsByDate(dateString);
            renderCalendar();
        }

        function filterEventsByDate(dateString) {
            const sidebarTitle = document.getElementById('sidebar-title');
            const eventsList = document.getElementById('events-list');
            const allEventCards = eventsList.querySelectorAll('[data-event-date]');
            
            if (!dateString) {
                sidebarTitle.textContent = 'All Events';
                allEventCards.forEach(card => card.style.display = 'block');
                return;
            }
            
            const dateObj = new Date(dateString + 'T00:00:00');
            const shortDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            sidebarTitle.textContent = `Events - ${shortDate}`;
            
            let visibleCount = 0;
            allEventCards.forEach(card => {
                if (card.dataset.eventDate === dateString) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show message if no events
            const existingEmpty = eventsList.querySelector('.empty-message');
            if (existingEmpty) existingEmpty.remove();
            
            if (visibleCount === 0) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'empty-message text-center py-8';
                emptyDiv.innerHTML = `
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-600 text-sm mb-3">No events on this date</p>
                    <button onclick="clearDateSelection()" class="text-blue-600 hover:text-blue-700 text-sm font-bold">View All Events</button>
                `;
                eventsList.appendChild(emptyDiv);
            }
        }

        function clearDateSelection() {
            selectedDate = null;
            const infoDiv = document.getElementById('selected-date-info');
            infoDiv.innerHTML = '<p class="text-center text-sm text-gray-500">Click on a date to view events for that day</p>';
            filterEventsByDate(null);
            renderCalendar();
        }

        function renderCalendar() {
            const monthName = currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            document.getElementById('calendar-month').textContent = monthName;

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            const today = new Date();

            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(date.getDate() + i);
                
                const dateString = date.toISOString().split('T')[0];
                const dayEvents = getEventsForDate(dateString);
                const dayBookings = getBookingsForDate(dateString);
                const hasEvent = dayEvents.length > 0 || dayBookings.length > 0;
                const isToday = date.toDateString() === today.toDateString();
                const isSelected = dateString === selectedDate;
                const isCurrentMonth = date.getMonth() === currentDate.getMonth();

                const day = document.createElement('div');
                day.className = 'relative text-center p-3 rounded-xl cursor-pointer min-h-16 flex flex-col items-center justify-center transition-all duration-300';
                day.onclick = () => isCurrentMonth && selectDate(dateString);

                if (isCurrentMonth) {
                    if (isToday || isSelected) {
                        day.classList.add('bg-blue-500', 'text-white', 'font-black', 'shadow-lg', 'scale-105', 'ring-2', 'ring-blue-300', 'hover:bg-blue-600');
                    } else if (hasEvent) {
                        day.classList.add('bg-blue-100', 'text-blue-900', 'font-bold', 'border-2', 'border-blue-400', 'hover:bg-blue-200', 'hover:scale-105', 'hover:shadow-md');
                    } else {
                        day.classList.add('bg-white', 'text-gray-700', 'font-semibold', 'border', 'border-gray-200', 'hover:bg-blue-50', 'hover:border-blue-300', 'hover:scale-105');
                    }
                } else {
                    day.classList.add('text-gray-400', 'bg-gray-50', 'cursor-not-allowed');
                    day.onclick = null;
                }

                const dateNumber = document.createElement('span');
                dateNumber.textContent = date.getDate();
                dateNumber.className = 'text-sm';
                day.appendChild(dateNumber);

                // Add event count indicator
                if (isCurrentMonth && hasEvent && !isToday && !isSelected) {
                    const eventCount = dayEvents.length + dayBookings.length;
                    const indicator = document.createElement('div');
                    indicator.className = 'mt-1';
                    indicator.innerHTML = `
                        <div class="flex gap-0.5 justify-center">
                            ${Array(Math.min(eventCount, 3)).fill('<div class="w-1 h-1 rounded-full bg-blue-600"></div>').join('')}
                        </div>
                    `;
                    day.appendChild(indicator);
                }

                calendar.appendChild(day);
            }
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        function goToToday() {
            currentDate = new Date();
            const todayString = currentDate.toISOString().split('T')[0];
            selectDate(todayString);
        }

        // Tab switching functionality - IMPROVED
        (function () {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            function switchTab(tabName) {
                // Hide all tabs
                tabContents.forEach(tab => {
                    tab.classList.add('hidden');
                });

                // Remove active state from all links
                tabLinks.forEach(link => {
                    link.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-500/20', 'scale-105');
                    link.classList.add('text-slate-900', 'bg-white', 'hover:bg-blue-50');
                });

                // Show selected tab
                const selectedTab = document.getElementById(`${tabName}-tab`);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }

                // Activate selected link
                const activeLink = document.querySelector(`.tab-link[data-tab="${tabName}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-slate-900', 'bg-white', 'hover:bg-blue-50');
                    activeLink.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-500/20', 'scale-105');
                }

                // Initialize calendar if calendar tab is opened
                if (tabName === 'calendar') {
                    renderCalendar();
                }
            }

            // Add click handlers to all tab links
            tabLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const tabName = link.dataset.tab;
                    switchTab(tabName);
                });
            });

            // Initialize first tab as active on page load
            if (tabLinks.length > 0) {
                switchTab(tabLinks[0].dataset.tab);
            }

            // If server requested an active tab, open it
            @if(session('active_tab'))
                switchTab("{{ session('active_tab') }}");
            @endif

            // Scroll-triggered animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        })();
    </script>

    {{-- ================= ANIMATIONS ================= --}}
    <style>
        /* Professional Typography */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .text-professional {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 400;
            letter-spacing: -0.01em;
        }

        .text-professional-medium {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        .text-professional-semibold {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .text-professional-bold {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .text-professional-black {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        @keyframes slideInLeft {
            from { 
                opacity: 0; 
                transform: translateX(-30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }

        @keyframes slideInRight {
            from { 
                opacity: 0; 
                transform: translateX(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }

        @keyframes countUp {
            from { 
                opacity: 0; 
                transform: scale(0.5); 
            }
            to { 
                opacity: 1; 
                transform: scale(1); 
            }
        }

        @keyframes pulse-slow {
            0%, 100% { 
                opacity: 1; 
            }
            50% { 
                opacity: 0.6; 
            }
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out;
        }

        .animate-countUp {
            animation: countUp 0.8s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Enhanced select dropdown styling */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        select option {
            background-color: #1e3a8a;
            color: #dbeafe;
            padding: 8px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #2563eb, #7c3aed);
        }

        /* Enhanced focus states */
        input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Professional card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Gradient text animation */
        .gradient-text {
            background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
            background-size: 400% 400%;
            animation: gradient-shift 4s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Scroll-triggered slide-in animations */
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .animate-on-scroll.slide-in-left {
            transform: translateX(-50px);
        }

        .animate-on-scroll.slide-in-right {
            transform: translateX(50px);
        }

        .animate-on-scroll.animate-visible {
            opacity: 1;
            transform: translateX(0) translateY(0);
        }

        /* Glass morphism effect */
        .glass {
            backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(17, 25, 40, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        /* Professional button effects */
        .btn-professional {
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
        }

        .btn-professional::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-professional:hover::before {
            left: 100%;
        }
    </style>

</x-app-layout>