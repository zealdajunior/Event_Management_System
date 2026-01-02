<x-app-layout>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-blue border-b border-black-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-10">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-15 h-15 ">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-green-600">Dashboard</h1>
                            <p class="text-sm text-green-600">Welcome back! Here's your event overview</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 text-sm text-green-600">
                            <div class="w-2 h-2 bg-green-600 rounded-full animate-pulse"></div>
                            <span>Live</span>
                        </div>

                        <a href="{{ route('event-requests.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-green-600 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Request Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= PAGE CONTAINER ================= --}}
    <div class="bg-gradient-to-br from-purple-900 via-pink-900 to-green-900 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= STATS OVERVIEW ================= --}}
            <div class="bg-blue-600 rounded-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                    $stats = [
                        ['label' => 'Upcoming Events', 'value' => $upcomingEventsCount, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'green', 'bgColor' => 'bg-green-50', 'textColor' => 'text-green-600'],
                        ['label' => 'Total Attendees', 'value' => $totalAttendees, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'green', 'bgColor' => 'bg-green-50', 'textColor' => 'text-green-600'],
                        ['label' => 'Revenue', 'value' => '$'.number_format($totalRevenue,2), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'green', 'bgColor' => 'bg-green-50', 'textColor' => 'text-green-600'],
                        ['label' => 'Notifications', 'value' => $notificationsCount, 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'green', 'bgColor' => 'bg-green-50', 'textColor' => 'text-green-600']
                    ];
                    @endphp

                    @foreach($stats as $stat)
                    <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">{{ $stat['label'] }}</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stat['value'] }}</p>
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

            {{-- ================= TAB NAVIGATION ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex flex-wrap gap-4">
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
                       class="tab-link flex-1 min-w-[140px] py-4 px-6 text-center rounded-xl
                              font-semibold text-gray-600 bg-gray-50
                              hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200
                              transition-all duration-200 relative group border border-gray-200
                              flex flex-col items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                        </svg>
                        <span class="text-sm">{{ $tab['label'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- ================= FEATURED EVENTS ================= --}}
            @if($featuredEvents->count())
            <div class="bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-purple-500/30 animate-fadeInUp animate-on-scroll">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl shadow-lg animate-bounce-slow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black bg-gradient-to-r from-purple-300 to-pink-300 bg-clip-text text-transparent">
                        Featured Events
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredEvents as $event)
            <div class="group relative animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-3xl blur-xl opacity-20 group-hover:opacity-50 transition-opacity duration-500"></div>
                <div class="relative bg-gradient-to-br from-purple-800/80 to-pink-900/80 backdrop-blur-xl border border-purple-500/30 rounded-3xl p-6
                                    hover:shadow-2xl hover:-translate-y-3 hover:rotate-1 group-hover:shadow-2xl group-hover:-translate-y-3 group-hover:rotate-1
                                    transition-all duration-500 overflow-hidden">

                            <div class="absolute top-4 right-4 animate-pulse-slow">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    ⭐ Featured
                                </span>
                            </div>

                            <h4 class="text-professional-black text-xl text-white mb-3 pr-20 leading-tight
                                       group-hover:text-white transition-colors duration-300">
                                {{ $event->name }}
                            </h4>

                            <p class="text-professional text-sm text-white leading-relaxed mb-4 line-clamp-2">
                                {{ Str::limit($event->description, 80) }}
                            </p>

                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $event->venue->name ?? 'TBD' }}</span>
                                </div>
                            </div>

                            <a href="{{ route('events.show', $event) }}"
                               class="inline-flex items-center gap-2 w-full justify-center
                                      bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700
                                      text-white px-6 py-3 rounded-2xl font-bold
                                      transform group-hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
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
            <div class="bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl p-6 border border-purple-500/30 animate-fadeIn">
                <form method="GET" action="{{ route('user.dashboard') }}"
                      class="flex flex-col lg:flex-row gap-4">

                    <div class="flex-1 relative group">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-purple-400 group-focus-within:text-purple-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search"
                               value="{{ $currentSearch }}"
                               placeholder="Search events by name, description, or venue..."
                               class="w-full pl-12 pr-5 py-4 rounded-2xl border-2 border-purple-500/30 bg-purple-900/30
                                      focus:ring-4 focus:ring-purple-400/20 focus:border-purple-400 placeholder-purple-300/50 text-purple-100
                                      transition-all duration-300 text-sm backdrop-blur-sm">
                    </div>

                    <select name="category"
                            class="px-5 py-4 rounded-2xl border-2 border-purple-500/30 bg-purple-900/30
                                   focus:ring-4 focus:ring-purple-400/20 focus:border-purple-400 text-purple-100
                                   transition-all duration-300 text-sm font-medium backdrop-blur-sm hover:border-purple-400/50">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $category)
                        <option value="{{ $category }}" {{ $currentCategory==$category?'selected':'' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>

                    <select name="type"
                            class="px-5 py-4 rounded-2xl border-2 border-purple-500/30 bg-purple-900/30
                                   focus:ring-4 focus:ring-purple-400/20 focus:border-purple-400 text-purple-100
                                   transition-all duration-300 text-sm font-medium backdrop-blur-sm hover:border-purple-400/50">
                        <option value="">All Types</option>
                        <option value="free" {{ $currentType=='free'?'selected':'' }}>Free Events</option>
                        <option value="paid" {{ $currentType=='paid'?'selected':'' }}>Paid Events</option>
                    </select>

                    <button type="submit"
                            class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700
                                   active:scale-95 transition-all duration-300
                                   text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl
                                   flex items-center justify-center gap-2 hover:gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>

                    @if($currentSearch || $currentCategory || $currentType)
                    <a href="{{ route('user.dashboard') }}"
                       class="bg-purple-700/50 hover:bg-purple-600/50 text-purple-100 border border-purple-500/30
                              px-6 py-4 rounded-2xl font-bold transition-all duration-300
                              flex items-center justify-center gap-2 backdrop-blur-sm hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                    @endif
                </form>
            </div>

            {{-- ================= EVENTS TAB ================= --}}
            <div id="events-tab" class="tab-content animate-fadeIn">
                <div class="">
                    <h3 class="text-white">Available Events</h3>
                    
                    <!-- ADD YOUR EVENTS LISTING HERE -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($availableEvents as $event)
            <div class="group relative animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-3xl blur-xl opacity-20 group-hover:opacity-50 transition-opacity duration-500"></div>
                <div class="relative bg-gradient-to-br from-blue-800/80 to-blue-900/80 backdrop-blur-xl border border-blue-500/30 rounded-3xl p-6
                                    hover:shadow-2xl hover:-translate-y-3 hover:rotate-1 group-hover:shadow-2xl group-hover:-translate-y-3 group-hover:rotate-1
                                    transition-all duration-500 overflow-hidden">
                    
                    <div class="absolute top-4 right-4 animate-pulse-slow">
                        <span class="bg-gradient-to-r from-green-400 to-blue-400 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            Available
                        </span>
                    </div>

                    <h4 class="text-professional-black text-xl text-white mb-3 pr-20 leading-tight
                               group-hover:text-white transition-colors duration-300">
                        {{ $event->name }}
                    </h4>

                    <p class="text-professional text-sm text-white leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit($event->description, 80) }}
                    </p>

                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">
                                {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
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
                                  bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                                  text-white px-6 py-3 rounded-2xl font-bold
                                  transform group-hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Book Now
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                            </svg>
                        </a>

                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center gap-2 w-full justify-center
                                  bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                  text-white px-6 py-3 rounded-2xl font-bold
                                  transform group-hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
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
                </div>
            </div>

            {{-- ================= TICKETS TAB ================= --}}
            <div id="tickets-tab" class="tab-content hidden animate-fadeIn">
                <div class="">
                    <h3 class="text-white">My Tickets</h3>
                    
                    <!-- ADD YOUR JAVASCRIPT FOR TICKET DISPLAY HERE -->
                    <div class="space-y-4">
                        @foreach($myTickets as $ticket)
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4
                                    border border-blue-500/30 p-6 rounded-2xl
                                    hover:shadow-xl hover:scale-[1.02] hover:border-blue-400/50
                                    transition-all duration-500 bg-gradient-to-r from-blue-900/50 to-blue-800/50 backdrop-blur-sm
                                    group animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-blue-100 mb-1 group-hover:text-white transition-colors duration-300">
                                    {{ $ticket->event->name }}
                                </p>
                                <p class="text-sm text-blue-300">
                                    Quantity: <span class="font-semibold text-blue-200">{{ $ticket->quantity }}</span>
                                </p>
                            </div>
                            <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-full
                                         text-sm font-bold shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 hover:from-blue-600 hover:to-blue-700">
                                ${{ number_format($ticket->total_price, 2) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ================= FAVORITES TAB ================= --}}
            <div id="favorites-tab" class="tab-content hidden animate-fadeIn">
                <div class="">
                    <h3 class="text-white">My Favorites</h3>

                    @if($myFavorites->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($myFavorites as $event)
            <div class="group relative animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 rounded-3xl blur-xl opacity-20 group-hover:opacity-50 transition-opacity duration-500"></div>
                <div class="relative bg-gradient-to-br from-red-800/80 to-pink-900/80 backdrop-blur-xl border border-red-500/30 rounded-3xl p-6
                                    hover:shadow-2xl hover:-translate-y-3 hover:rotate-1 group-hover:shadow-2xl group-hover:-translate-y-3 group-hover:rotate-1
                                    transition-all duration-500 overflow-hidden">

                    <div class="absolute top-4 right-4 animate-pulse-slow">
                        <span class="bg-gradient-to-r from-red-400 to-pink-400 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            ⭐ Favorite
                        </span>
                    </div>

                    <h4 class="text-professional-black text-xl text-white mb-3 pr-20 leading-tight
                               group-hover:text-white transition-colors duration-300">
                        {{ $event->name }}
                    </h4>

                    <p class="text-professional text-sm text-white leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit($event->description, 80) }}
                    </p>

                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">
                                {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-professional-medium text-sm text-white group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">{{ $event->venue->name ?? 'TBD' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('bookings.create.for.event', $event) }}"
                           class="inline-flex items-center gap-2 w-full justify-center
                                  bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                                  text-white px-6 py-3 rounded-2xl font-bold
                                  transform group-hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Book Now
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1-5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                            </svg>
                        </a>

                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center gap-2 w-full justify-center
                                  bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                  text-white px-6 py-3 rounded-2xl font-bold
                                  transform group-hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
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
                            <div class="p-6 bg-gradient-to-r from-red-500/20 to-pink-500/20 rounded-3xl inline-block mb-6 border border-white/10">
                                <svg class="w-16 h-16 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold text-white mb-2">No Favorites Yet</h4>
                            <p class="text-white/70 text-lg mb-6">Start adding events to your favorites to see them here</p>
                            <a href="#events"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700
                                      text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-red-500/30
                                      hover:shadow-xl hover:shadow-red-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
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
                <div class="">
                    <h3 class="text-white">Event Calendar</h3>
                    
                    <!-- ADD YOUR JAVASCRIPT FOR CALENDAR DISPLAY HERE -->
                    <div id="calendar" class="grid grid-cols-7 gap-2">
                        <!-- Calendar will be populated by JavaScript -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= JAVASCRIPT (ADD YOUR TAB SWITCHING LOGIC HERE) ================= --}}
    <script>
        // Tab switching functionality
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();

                // Remove active state from all tabs
                tabLinks.forEach(l => {
                    l.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'scale-105');
                    l.classList.add('text-blue-200');
                });
                
                // Hide all tab contents
                tabContents.forEach(c => c.classList.add('hidden'));

                // Activate clicked tab
                const tab = link.dataset.tab;
                document.getElementById(`${tab}-tab`).classList.remove('hidden');

                // Style active tab
                link.classList.remove('text-blue-200');
                link.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'scale-105');
            });
        });

        // Initialize first tab as active
        if (tabLinks.length > 0) {
            tabLinks[0].classList.remove('text-blue-200');
            tabLinks[0].classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'scale-105');
        }

        // Scroll-triggered animations using Intersection Observer
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

        // Observe all elements with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
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