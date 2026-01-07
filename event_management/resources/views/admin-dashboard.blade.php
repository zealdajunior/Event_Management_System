<x-app-layout>
    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-purple-900/80 via-pink-900/80 to-green-900/80 backdrop-blur-xl rounded-3xl p-8 mb-8 shadow-2xl border border-white/10">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 left-0 w-72 h-72 bg-white/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div class="absolute top-0 right-0 w-72 h-72 bg-white/30 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-white/25 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="animate-slideInLeft">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg animate-pulse-slow backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl lg:text-5xl font-black text-white">
                                Admin Dashboard
                            </h1>
                            <div class="h-1 w-24 bg-gradient-to-r from-white/60 to-white/80 rounded-full mt-2"></div>
                        </div>
                    </div>
                    <p class="text-lg text-white flex items-center gap-3">
                        <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Manage events, users, and system analytics
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 animate-slideInRight">
                    <a href="{{ route('events.create') }}"
                       class="group relative bg-gradient-to-r from-white/20 via-white/30 to-white/20 hover:from-white/30 hover:via-white/40 hover:to-white/30
                              active:scale-95 transition-all duration-500
                              text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-white/20
                              hover:shadow-3xl hover:shadow-white/30 flex items-center gap-3
                              overflow-hidden backdrop-blur-sm border border-white/20">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="relative z-10">Create Event</span>
                        <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </a>

                    <a href="{{ route('venues.create') }}"
                       class="group relative bg-gradient-to-r from-white/20 via-white/30 to-white/20 hover:from-white/30 hover:via-white/40 hover:to-white/30
                              active:scale-95 transition-all duration-500
                              text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-white/20
                              hover:shadow-3xl hover:shadow-white/30 flex items-center gap-3
                              overflow-hidden backdrop-blur-sm border border-white/20">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="relative z-10">Add Venue</span>
                        <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </a>

                    <div class="flex items-center gap-2 text-white/70">
                        <div class="w-3 h-3 bg-white/60 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium">Admin Panel</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ================= STATS OVERVIEW ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12 animate-on-scroll">
                <!-- Total Events -->
                <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium mb-1">Total Events</p>
                            <p class="text-3xl font-black text-white">{{ $totalEvents }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-xs text-white/70">Active</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium mb-1">Total Users</p>
                            <p class="text-3xl font-black text-white">{{ $totalUsers }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-xs text-white/70">Registered</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium mb-1">Pending Requests</p>
                            <p class="text-3xl font-black text-white">{{ $pendingRequests }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-xs text-white/70">Awaiting Review</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Events -->
                <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium mb-1">Recent Events</p>
                            <p class="text-3xl font-black text-white">{{ $recentEvents->count() }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-xs text-white/70">This Month</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683l-3-3m3 3l3-3m-3 3V9a6 6 0 1112 0v12l-3-3"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium mb-1">Total Bookings</p>
                            <p class="text-3xl font-black text-white">{{ $totalBookings }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-xs text-white/70">Confirmed</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= NAVIGATION TABS ================= --}}
            <div class="mb-12 animate-on-scroll">
                <nav class="relative bg-black/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 p-3" aria-label="Tabs">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-900/20 via-pink-900/20 to-green-900/20 rounded-3xl"></div>
                    <div class="relative flex space-x-2">
                        <a href="#events" class="tab-link group flex-1 text-center py-4 px-6 rounded-2xl text-sm font-bold transition-all duration-500
                           bg-gradient-to-r from-white/20 via-white/30 to-white/20 text-white shadow-lg shadow-white/20
                           hover:shadow-xl hover:shadow-white/30 hover:scale-105 active:scale-95" data-tab="events">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Events</span>
                            </div>
                        </a>
                        <a href="#bookings" class="tab-link group flex-1 text-center py-4 px-6 rounded-2xl text-sm font-bold transition-all duration-500
                           text-white hover:text-white hover:bg-gradient-to-r hover:from-white/20 hover:to-white/30
                           hover:shadow-lg hover:shadow-white/20 hover:scale-105 active:scale-95" data-tab="bookings">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Bookings</span>
                            </div>
                        </a>
                        <a href="#users" class="tab-link group flex-1 text-center py-4 px-6 rounded-2xl text-sm font-bold transition-all duration-500
                           text-white hover:text-white hover:bg-gradient-to-r hover:from-white/20 hover:to-white/30
                           hover:shadow-lg hover:shadow-white/20 hover:scale-105 active:scale-95" data-tab="users">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Users</span>
                            </div>
                        </a>
                        <a href="#requests" class="tab-link group flex-1 text-center py-4 px-6 rounded-2xl text-sm font-bold transition-all duration-500
                           text-white hover:text-white hover:bg-gradient-to-r hover:from-white/20 hover:to-white/30
                           hover:shadow-lg hover:shadow-white/20 hover:scale-105 active:scale-95" data-tab="requests">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Requests</span>
                            </div>
                        </a>
                        <a href="#analytics" class="tab-link group flex-1 text-center py-4 px-6 rounded-2xl text-sm font-bold transition-all duration-500
                           text-white hover:text-white hover:bg-gradient-to-r hover:from-white/20 hover:to-white/30
                           hover:shadow-lg hover:shadow-white/20 hover:scale-105 active:scale-95" data-tab="analytics">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Analytics</span>
                            </div>
                        </a>
                    </div>
                </nav>
            </div>

            {{-- ================= EVENTS TAB ================= --}}
            <div id="events-tab" class="tab-content animate-on-scroll">
                <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                            <div>
                                <h3 class="text-3xl font-black text-white mb-2">
                                    Recent Events
                                </h3>
                                <p class="text-white/70 text-lg">Manage and monitor your latest events</p>
                            </div>
                            <a href="{{ route('events.index') }}"
                               class="group relative bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 hover:from-blue-600 hover:via-blue-700 hover:to-purple-700
                                      active:scale-95 transition-all duration-500
                                      text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-blue-500/30
                                      hover:shadow-3xl hover:shadow-blue-500/50 flex items-center gap-3
                                      overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="relative z-10">View All Events</span>
                                <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                            </a>
                        </div>

                        @if($recentEvents->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentEvents as $event)
                                    <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-white/20 to-white/30 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>
                                        <div class="relative">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="p-3 bg-gradient-to-r from-white/20 to-white/30 rounded-2xl shadow-lg backdrop-blur-sm">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 bg-white/60 rounded-full animate-pulse"></div>
                                                    <span class="text-xs text-white/70 font-medium">Active</span>
                                                </div>
                                            </div>
                                            <h4 class="text-xl font-bold text-white mb-2 group-hover:text-white/80 transition-colors duration-300">{{ $event->name }}</h4>
                                            <p class="text-white/70 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>
                                            <div class="space-y-2 mb-6">
                                                <div class="flex items-center gap-2 text-sm text-white/70">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-white/70">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                    <span>{{ $event->venue->name ?? 'TBD' }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('events.show', $event) }}"
                                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-white/20 via-white/30 to-white/20 hover:from-white/30 hover:via-white/40 hover:to-white/30
                                                      text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-2xl shadow-white/20
                                                      hover:shadow-3xl hover:shadow-white/30 transition-all duration-300 hover:scale-105 active:scale-95 backdrop-blur-sm border border-white/20">
                                                <span>View Details</span>
                                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="p-6 bg-gradient-to-r from-blue-100 to-purple-100 rounded-3xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Recent Events</h4>
                                <p class="text-gray-600 text-lg mb-6">Start creating amazing events to see them here</p>
                                <a href="{{ route('events.create') }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700
                                          text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                          hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Create Your First Event</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================= BOOKINGS TAB ================= --}}
            <div id="bookings-tab" class="tab-content hidden animate-on-scroll">
                <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                            <div>
                                <h3 class="text-3xl font-black text-white mb-2">
                                    Recent Bookings
                                </h3>
                                <p class="text-white/70 text-lg">Monitor ticket sales and booking activity</p>
                            </div>
                            <a href="{{ route('bookings.index') }}"
                               class="group relative bg-gradient-to-r from-purple-500 via-purple-600 to-pink-600 hover:from-purple-600 hover:via-purple-700 hover:to-pink-700
                                      active:scale-95 transition-all duration-500
                                      text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-purple-500/30
                                      hover:shadow-3xl hover:shadow-purple-500/50 flex items-center gap-3
                                      overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="relative z-10">View All Bookings</span>
                                <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                            </a>
                        </div>

                        @if($recentBookings->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentBookings as $booking)
                                    <div class="group relative bg-gradient-to-br from-white to-purple-50/50 p-6 rounded-3xl shadow-xl border border-white/50
                                                hover:shadow-2xl hover:scale-105 transition-all duration-500 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                                        <div class="relative">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl shadow-lg">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                                    <span class="text-xs text-gray-500 font-medium">Confirmed</span>
                                                </div>
                                            </div>

                                            <div class="space-y-3 mb-6">
                                                <div class="flex items-center gap-2 text-sm">
                                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span class="font-semibold text-gray-900">{{ $booking->user->name }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ $booking->event->name }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                    </svg>
                                                    <span>{{ $booking->ticket->type }} - <span class="font-semibold text-green-600">${{ $booking->ticket->price }}</span></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>{{ $booking->booking_date->format('M d, Y H:i') }}</span>
                                                </div>
                                            </div>

                                            <a href="{{ route('bookings.show', $booking) }}"
                                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700
                                                      text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-purple-500/30
                                                      hover:shadow-xl hover:shadow-purple-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                                <span>View Details</span>
                                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="p-6 bg-gradient-to-r from-purple-100 to-pink-100 rounded-3xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Recent Bookings</h4>
                                <p class="text-gray-600 text-lg mb-6">Bookings will appear here once users start purchasing tickets</p>
                                <a href="{{ route('events.index') }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700
                                          text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-purple-500/30
                                          hover:shadow-xl hover:shadow-purple-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>View Events</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================= USERS TAB ================= --}}
            <div id="users-tab" class="tab-content hidden animate-on-scroll">
                <div class="relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                            <div>
                                <h3 class="text-3xl font-black text-white mb-2">
                                    User Management
                                </h3>
                                <p class="text-white/70 text-lg">Monitor and manage user accounts and roles</p>
                            </div>
                            <a href="{{ route('users.index') }}"
                               class="group relative bg-gradient-to-r from-green-500 via-green-600 to-teal-600 hover:from-green-600 hover:via-green-700 hover:to-teal-700
                                      active:scale-95 transition-all duration-500
                                      text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-green-500/30
                                      hover:shadow-3xl hover:shadow-green-500/50 flex items-center gap-3
                                      overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="relative z-10">Manage Users</span>
                                <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <!-- Total Users Card -->
                            <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                                <div class="relative flex items-center justify-between">
                                    <div>
                                        <p class="text-white text-sm font-medium mb-1">Total Users</p>
                                        <p class="text-3xl font-black text-white">{{ $totalUsers }}</p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-white/70">Registered</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Users Card -->
                            <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                                <div class="relative flex items-center justify-between">
                                    <div>
                                        <p class="text-white text-sm font-medium mb-1">Admin Users</p>
                                        <p class="text-3xl font-black text-white">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-white/70">Privileged</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Regular Users Card -->
                            <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-700"></div>
                                <div class="relative flex items-center justify-between">
                                    <div>
                                        <p class="text-white text-sm font-medium mb-1">Regular Users</p>
                                        <p class="text-3xl font-black text-white">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-white/70 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-white/70">Active</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-2xl group-hover:bg-white/30 transition-colors duration-300 backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Users Card -->
                            <div class="group relative bg-gradient-to-br from-purple-900/60 via-pink-900/60 to-green-900/60 backdrop-blur-xl p-6 rounded-3xl shadow-2xl shadow-white/10 hover:shadow-3xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-500 overflow-hidden border border-white/10">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            {{-- ================= REQUESTS TAB ================= --}}
            <div id="requests-tab" class="tab-content hidden animate-on-scroll">
                <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 via-red-50/50 to-pink-50/50"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                            <div>
                                <h3 class="text-3xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                                    Event Requests
                                </h3>
                                <p class="text-gray-600 text-lg">Review and manage event creation requests</p>
                            </div>
                            <a href="{{ route('admin.event_requests.index') }}"
                               class="group relative bg-gradient-to-r from-orange-500 via-orange-600 to-red-600 hover:from-orange-600 hover:via-orange-700 hover:to-red-700
                                      active:scale-95 transition-all duration-500
                                      text-white px-8 py-4 rounded-2xl font-bold shadow-2xl shadow-orange-500/30
                                      hover:shadow-3xl hover:shadow-orange-500/50 flex items-center gap-3
                                      overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="relative z-10">View All Requests</span>
                                <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                            </a>
                        </div>

                        @if($eventRequests->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($eventRequests as $request)
                                    <div class="group relative bg-gradient-to-br from-white to-orange-50/50 p-6 rounded-3xl shadow-xl border border-white/50
                                                hover:shadow-2xl hover:scale-105 transition-all duration-500 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-400/20 to-red-400/20 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                                        <div class="relative">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="p-3 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 {{ $request->status === 'pending' ? 'bg-yellow-400' : ($request->status === 'approved' ? 'bg-green-400' : 'bg-red-400') }} rounded-full animate-pulse"></div>
                                                    <span class="text-xs text-gray-500 font-medium capitalize">{{ $request->status }}</span>
                                                </div>
                                            </div>

                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors duration-300">{{ $request->title }}</h4>
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $request->description }}</p>

                                            <div class="space-y-3 mb-6">
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span>Requested by: <span class="font-semibold text-gray-900">{{ $request->user->name }}</span></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ $request->created_at->format('M d, Y H:i') }}</span>
                                                </div>
                                            </div>

                                            <a href="{{ route('event-requests.show', $request) }}"
                                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700
                                                      text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-orange-500/30
                                                      hover:shadow-xl hover:shadow-orange-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                                <span>Review Request</span>
                                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="p-6 bg-gradient-to-r from-orange-100 to-red-100 rounded-3xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Pending Requests</h4>
                                <p class="text-gray-600 text-lg mb-6">All event requests have been processed or none have been submitted yet</p>
                                <a href="{{ route('event-requests.create') }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700
                                          text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30
                                          hover:shadow-xl hover:shadow-orange-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Submit New Request</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-tab" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Analytics</h3>
                        <p class="text-gray-500 dark:text-gray-400">Analytics features coming soon. Track event performance, user engagement, and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    (function () {
        // Prevent double-initialization when Livewire swaps DOM fragments
        if (window.__adminDashboardInit) return;
        window.__adminDashboardInit = true;

        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const tab = this.dataset.tab;

                // Update URL hash without reloading
                history.replaceState(null, null, '#' + tab);

                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab
                document.getElementById(tab + '-tab').classList.remove('hidden');

                // Update active styling
                document.querySelectorAll('.tab-link').forEach(l => {
                    l.classList.remove('bg-blue-100', 'text-blue-700');
                });
                this.classList.add('bg-blue-100', 'text-blue-700');
            });
        });

        // Load tab from URL hash on refresh
        const currentTab = window.location.hash.replace('#', '') || 'events';
        document.getElementById(currentTab + '-tab').classList.remove('hidden');
        document.querySelector('.tab-link[data-tab="' + currentTab + '"]').classList.add('bg-blue-100', 'text-blue-700');
    })();
</script>

</x-app-layout>
