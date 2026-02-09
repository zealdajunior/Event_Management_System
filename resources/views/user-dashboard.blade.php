<x-app-layout>
    {{-- Chart.js CDN for interactive charts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ================= ANIMATIONS ================= --}}
    <style>
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
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-soft {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-soft {
            animation: pulse-soft 2s ease-in-out infinite;
        }

        .stagger-animation > * {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stagger-animation > *:nth-child(1) { animation-delay: 0.1s; }
        .stagger-animation > *:nth-child(2) { animation-delay: 0.2s; }
        .stagger-animation > *:nth-child(3) { animation-delay: 0.3s; }
        .stagger-animation > *:nth-child(4) { animation-delay: 0.4s; }
        .stagger-animation > *:nth-child(5) { animation-delay: 0.5s; }
        .stagger-animation > *:nth-child(6) { animation-delay: 0.6s; }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #667eea 0%, #764ba2 100%) border-box;
            border: 2px solid transparent;
        }

        .shimmer {
            background: linear-gradient(90deg, 
                rgba(255,255,255,0) 0%, 
                rgba(255,255,255,0.3) 50%, 
                rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.8), 0 0 30px rgba(59, 130, 246, 0.6); }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            33% { transform: translateY(-8px) translateX(8px); }
            66% { transform: translateY(8px) translateX(-8px); }
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            10%, 30% { transform: scale(1.1); }
            20%, 40% { transform: scale(1); }
        }

        .animate-rotate {
            animation: rotate 20s linear infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }

        .animate-wave {
            animation: wave 2s ease-in-out infinite;
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }

        .animate-gradient-shift {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .animate-float-slow {
            animation: float-slow 6s ease-in-out infinite;
        }

        .animate-heartbeat {
            animation: heartbeat 2s ease-in-out infinite;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: glow 1.5s ease-in-out infinite;
        }
    </style>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pt-6 sm:pt-4 pb-0 gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 animate-pulse-soft">
                            <svg class="w-6 h-6 text-blue-600 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-blue-800">Dashboard</h1>
                            <p class="text-xs sm:text-sm text-blue-600">Welcome back! Here's your event overview</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                        <div class="hidden sm:flex items-center space-x-2 text-sm text-blue-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse animate-glow"></div>
                            <span class="animate-pulse-soft">Live</span>
                        </div>

                        <!-- Request Event Button -->
                        <div class="ml-auto">
                            <flux:button href="{{ route('event-requests.create') }}" variant="primary" size="sm" class="flex-1 sm:flex-none">
                                <flux:icon name="plus" class="w-4 h-4" />
                                <span class="hidden xs:inline sm:inline">Request Event</span>
                                <span class="xs:hidden">Request</span>
                            </flux:button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= EMAIL VERIFICATION REMINDER ================= --}}
    @if(session('verification_reminder'))
        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 mx-4 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-blue-700 font-medium">{{ session('verification_reminder') }}</p>
                    <p class="text-blue-600 text-sm mt-1">
                        <a href="{{ route('verification.notice') }}" class="underline hover:text-blue-800">Click here to resend verification email</a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user() && !auth()->user()->hasVerifiedEmail() && !(auth()->user()->is_super_admin ?? false))
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mx-4 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-blue-700 font-medium">Please verify your email address</p>
                    <p class="text-blue-600 text-sm mt-1">
                        Check your inbox for a verification link or 
                        <a href="{{ route('verification.notice') }}" class="underline hover:text-blue-800">resend verification email</a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- ================= PAGE CONTAINER ================= --}}
    <div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(!$hasCreatedEvents)
            {{-- ================= ENCOURAGE EVENT CREATION ================= --}}
            <div class="bg-gradient-to-br from-blue-50 via-white to-purple-50 rounded-xl shadow-sm border border-blue-50 p-6 text-center animate-fade-in-up">
                <div class="mb-2">
                    <div class="flex items-center justify-center mb-4">
                        <div class="p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg animate-float animate-glow">
                            <svg class="w-12 h-12 text-white animate-wave" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-blue-800 mb-4">🚀 Ready to Host Amazing Events?</h2>
                    <p class="text-blue-600 mb-4">Submit your event request and get approved to start hosting!</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 stagger-animation">
                    <div class="bg-white rounded-lg p-6 border border-blue-50 card-hover">
                        <div class="text-blue-500 text-3xl mb-3 animate-bounce-slow">📊</div>
                        <h3 class="font-semibold text-blue-800 mb-4">Analytics Dashboard</h3>
                        <p class="text-sm text-blue-600">Track registrations, revenue, and event performance</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-blue-50 card-hover">
                        <div class="text-purple-500 text-3xl mb-3 animate-wave">👥</div>
                        <h3 class="font-semibold text-blue-800 mb-4">Attendee Management</h3>
                        <p class="text-sm text-blue-600">Manage registrations and attendee engagement</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-blue-50 card-hover">
                        <div class="text-green-500 text-3xl mb-3 animate-heartbeat">💰</div>
                        <h3 class="font-semibold text-blue-800 mb-4">Revenue Tracking</h3>
                        <p class="text-sm text-blue-600">Monitor ticket sales and revenue growth</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('event-requests.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-6 px-8 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Request Your First Event
                    </a>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-blue-400 hover:bg-blue-50 text-blue-700 font-bold py-6 px-8 rounded-xl transition-all duration-300 hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Browse All Events
                    </a>
                </div>
            </div>
            @endif

            {{-- ================= PERSONALIZED RECOMMENDATIONS ================= --}}
            @if($recommendedEvents && $recommendedEvents->count() > 0)
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-50 animate-slide-in-left">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl shadow-md animate-pulse-soft animate-glow">
                        <svg class="w-6 h-6 text-white animate-rotate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-800">Just For You</h3>
                        <p class="text-sm text-blue-600 animate-pulse-soft">Based on your interests</p>
                    </div>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 stagger-animation">
                    @foreach($recommendedEvents as $event)
                    <div class="bg-white rounded-xl p-6 shadow-sm card-hover border border-blue-200 border-blue-100/50 flex flex-col gradient-border" style="height: 520px;">
                        <div class="flex justify-between items-start mb-3" style="height: 28px;">
                            <div class="flex flex-wrap gap-1">
                                @if($event->category && is_object($event->category))
                                    <span class="text-xs font-bold px-2 py-1 rounded-full" 
                                          style="background-color: {{ $event->category->color ?? '#3B82F6' }}20; color: {{ $event->category->color ?? '#3B82F6' }};">
                                        @if(isset($event->category->icon) && $event->category->icon)
                                            <i class="fas fa-{{ $event->category->icon }} mr-1"></i>
                                        @endif
                                        {{ $event->category->name ?? $event->category }}
                                    </span>
                                @elseif($event->category && is_string($event->category))
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        {{ $event->category }}
                                    </span>
                                @endif
                            </div>
                            <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse-soft animate-glow">✨ Recommended</span>
                        </div>
                        
                        <h4 class="font-bold text-xl text-blue-800 leading-tight line-clamp-2 mb-3" style="height: 56px;">{{ $event->name }}</h4>
                        
                        <p class="text-sm text-blue-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">{{ $event->description }}</p>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 50px;">
                            <div class="flex items-center gap-2 text-sm text-blue-600 mb-4" style="height: 20px;">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'TBD' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-blue-600" style="height: 20px;">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-blue-400 hover:bg-blue-50 text-blue-700 font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
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
            <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl p-6 shadow-lg animate-slide-in-right">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md animate-pulse-soft">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-blue-900">Trending Now 🔥</h3>
                        <p class="text-sm text-blue-600">Most popular events</p>
                    </div>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 stagger-animation">
                    @foreach($trendingEvents as $event)
                    <div class="bg-white rounded-xl p-6 shadow-sm card-hover border border-blue-100 flex flex-col" style="height: 520px;">
                        <div class="flex justify-between items-start mb-3" style="height: 28px;">
                            <div class="flex flex-wrap gap-1">
                                @if($event->category && is_object($event->category))
                                    <span class="text-xs font-bold px-2 py-1 rounded-full" 
                                          style="background-color: {{ $event->category->color ?? '#F59E0B' }}20; color: {{ $event->category->color ?? '#F59E0B' }};">
                                        @if(isset($event->category->icon) && $event->category->icon)
                                            <i class="fas fa-{{ $event->category->icon }} mr-1"></i>
                                        @endif
                                        {{ $event->category->name ?? $event->category }}
                                    </span>
                                @elseif($event->category && is_string($event->category))
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-orange-100 text-orange-700">
                                        {{ $event->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 Hot</span>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">{{ $event->bookings_count }} bookings</span>
                            </div>
                        </div>
                        
                        <h4 class="font-black text-xl text-blue-800 leading-tight line-clamp-2 mb-3" style="height: 56px;">{{ $event->name }}</h4>
                        
                        <p class="text-sm text-blue-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">{{ $event->description }}</p>
                        
                        <div class="mb-4 flex-shrink-0" style="height: 50px;">
                            <div class="flex items-center gap-2 text-sm text-blue-600 mb-4" style="height: 20px;">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-xs truncate">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'TBD' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-blue-600" style="height: 20px;">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <a href="{{ route('bookings.create.for.event', $event) }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-blue-400 hover:bg-blue-50 text-blue-700 font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:shadow-lg text-sm">
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
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 shadow-xl text-white animate-scale-in shimmer">
                <div class="text-center mb-4">
                    <h3 class="text-3xl font-black mb-4">Your Journey 🎉</h3>
                    <p class="text-blue-100">Member since {{ $userStats['member_since'] }}</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 stagger-animation">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-110 card-hover">
                        <div class="text-4xl font-black mb-4">{{ $userStats['events_attended'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Events Booked</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-110 card-hover">
                        <div class="text-4xl font-black mb-4 animate-pulse-soft">{{ $userStats['upcoming_bookings'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Upcoming</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-110 card-hover">
                        <div class="text-4xl font-black mb-4">{{ $userStats['favorites_count'] }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Favorites</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center hover:bg-white/20 transition-all duration-300 hover:scale-110 card-hover">
                        <div class="text-4xl font-black mb-4">{{ count(auth()->user()->interests ?? []) }}</div>
                        <div class="text-sm text-blue-100 font-semibold">Interests</div>
                    </div>
                </div>
            </div>

            {{-- ================= TAB NAVIGATION ================= --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 stagger-animation">
                @php
                $tabs = [
                    'events' => ['label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    'analytics' => ['label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    'tickets' => ['label' => 'Tickets', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                    'favorites' => ['label' => 'Favorites', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    'calendar' => ['label' => 'Calendar', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2']
                ];
                @endphp

                @foreach($tabs as $key => $tab)
                <a href="#{{ $key }}" data-tab="{{ $key }}"
                   class="tab-link py-5 px-6 text-center rounded-2xl font-bold text-blue-700
                          bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-purple-50
                          border border-blue-100 hover:border-blue-300
                          transition-all duration-300 hover:shadow-lg hover:-translate-y-1
                          flex flex-col items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                    </svg>
                    <span class="text-sm">{{ $tab['label'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- ================= ANALYTICS TAB ================= --}}
            <div id="analytics-tab" class="tab-content animate-fadeIn hidden">
                {{-- ================= USER ANALYTICS OVERVIEW ================= --}}
                <div class="bg-white rounded-xl shadow-sm border border-blue-50 p-6 mb-4">
                    <div class="mb-4">
                        <h2 class="text-xl font-bold text-blue-800 mb-4">Your Event Analytics</h2>
                        <p class="text-sm text-blue-600">Track your event activity and engagement</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                        $enhancedStats = [
                            [
                                'label' => 'Events Attended', 
                                'value' => $userEventsAttended, 
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 
                                'color' => 'green',
                                'change' => '+' . ($userUpcomingEvents) . ' upcoming',
                                'changeColor' => 'text-green-600'
                            ],
                            [
                                'label' => 'Total Spending', 
                                'value' => '$' . number_format($userSpending, 2), 
                                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 
                                'color' => 'blue',
                                'change' => 'Lifetime total',
                                'changeColor' => 'text-blue-600'
                            ],
                            [
                                'label' => 'Favorite Events', 
                                'value' => $userStats['favorites_count'], 
                                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 
                                'color' => 'pink',
                                'change' => 'Saved for later',
                                'changeColor' => 'text-pink-600'
                            ],
                            [
                                'label' => 'Notifications', 
                                'value' => $notificationsCount, 
                                'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 
                                'color' => 'amber',
                                'change' => 'Unread messages',
                                'changeColor' => 'text-amber-600'
                            ]
                        ];
                        @endphp

                        @foreach($enhancedStats as $stat)
                        <div class="bg-gradient-to-br from-white to-gray-50  rounded-xl p-6 border border-blue-50 hover:shadow-lg transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-xl bg-{{ $stat['color'] }}-50  group-hover:scale-110 transition-transform duration-200">
                                    <svg class="w-6 h-6 text-{{ $stat['color'] }}-600 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{!! $stat['icon'] !!}"></path>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-blue-800 group-hover:scale-105 transition-transform duration-200">{{ $stat['value'] }}</p>
                                    <p class="text-sm font-medium text-blue-600 mt-1">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="h-1 bg-gradient-to-r from-{{ $stat['color'] }}-200 to-{{ $stat['color'] }}-400  rounded-full flex-1"></div>
                                <span class="text-xs {{ $stat['changeColor'] }} font-medium ml-2">{{ $stat['change'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                {{-- ================= EVENT CREATOR ANALYTICS (Conditional Display) ================= --}}
                @if($hasCreatedEvents)
                <div class="bg-gradient-to-br from-green-50 via-white to-green-100  rounded-xl shadow-sm border border-green-200 border-green-200 p-6 mb-4">
                    <div class="mb-6 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-md">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-green-900 text-green-800 mb-4">📊 Event Creator Analytics</h2>
                        <p class="text-sm text-green-600 text-green-600">Your event management performance dashboard</p>
                    </div>

                    {{-- Creator Stats Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                        @php
                        $creatorStats = [
                            [
                                'label' => 'Events Created',
                                'value' => $creatorAnalytics['total_events_created'],
                                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z',
                                'color' => 'green',
                                'change' => $creatorAnalytics['active_events'] . ' active',
                                'changeColor' => 'text-green-600'
                            ],
                            [
                                'label' => 'Total Registrations',
                                'value' => $creatorAnalytics['total_registrations'],
                                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                'color' => 'blue',
                                'change' => 'Across all events',
                                'changeColor' => 'text-blue-600'
                            ],
                            [
                                'label' => 'Ticket Sales',
                                'value' => '$' . number_format($creatorAnalytics['ticket_sales_simulation'], 2),
                                'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
                                'color' => 'purple',
                                'change' => 'Simulated revenue',
                                'changeColor' => 'text-purple-600'
                            ],
                            [
                                'label' => 'Upcoming Events',
                                'value' => $creatorAnalytics['upcoming_events'],
                                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                'color' => 'orange',
                                'change' => $creatorAnalytics['past_events'] . ' completed',
                                'changeColor' => 'text-orange-600'
                            ]
                        ];
                        @endphp

                        @foreach($creatorStats as $stat)
                        <div class="bg-white  rounded-xl p-6 border border-green-200 border-green-200/50 hover:shadow-lg  transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-xl bg-{{ $stat['color'] }}-50  group-hover:scale-110 transition-transform duration-200">
                                    <svg class="w-6 h-6 text-{{ $stat['color'] }}-600 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{!! $stat['icon'] !!}"></path>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-green-900 text-green-800 group-hover:scale-105 transition-transform duration-200">{{ $stat['value'] }}</p>
                                    <p class="text-sm font-medium text-green-600 text-green-600 mt-1">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="h-1 bg-gradient-to-r from-{{ $stat['color'] }}-200 to-{{ $stat['color'] }}-400  rounded-full flex-1"></div>
                                <span class="text-xs {{ $stat['changeColor'] }} font-medium ml-2">{{ $stat['change'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Creator Performance Charts --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4">
                        <div class="bg-white  rounded-xl shadow-sm border border-green-200 border-green-200/50 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-green-900 text-green-800">Events Created</h3>
                                    <p class="text-sm text-green-600 text-green-600">Monthly event creation trend</p>
                                </div>
                                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div style="height: 300px;">
                                <canvas id="creatorEventsChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white  rounded-xl shadow-sm border border-green-200 border-green-200/50 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-green-900 text-green-800">Event Registrations</h3>
                                    <p class="text-sm text-green-600 text-green-600">Monthly registration performance</p>
                                </div>
                                <div class="p-2 bg-blue-50 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div style="height: 300px;">
                                <canvas id="creatorRegistrationsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{-- ================= ENCOURAGE EVENT CREATION ================= --}}
                <div class="bg-gradient-to-br from-blue-50 via-white to-purple-50 rounded-xl shadow-sm border border-blue-50 p-6 text-center mb-4">
                    <div class="mb-4">
                        <div class="flex items-center justify-center mb-4">
                            <div class="p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-blue-800 mb-4">🚀 Ready to Create Amazing Events?</h2>
                        <p class="text-blue-600 mb-4">Start your event management journey and unlock powerful analytics!</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div class="bg-white rounded-lg p-6 border border-blue-50">
                            <div class="text-blue-500 text-3xl mb-3">📊</div>
                            <h3 class="font-semibold text-blue-800 mb-4">Analytics Dashboard</h3>
                            <p class="text-sm text-blue-600">Track registrations, revenue, and event performance</p>
                        </div>
                        <div class="bg-white rounded-lg p-6 border border-blue-50">
                            <div class="text-purple-500 text-3xl mb-3">👥</div>
                            <h3 class="font-semibold text-blue-800 mb-4">Attendee Management</h3>
                            <p class="text-sm text-blue-600">Manage registrations and attendee engagement</p>
                        </div>
                        <div class="bg-white rounded-lg p-6 border border-blue-50">
                            <div class="text-green-500 text-3xl mb-3">💰</div>
                            <h3 class="font-semibold text-blue-800 mb-4">Revenue Tracking</h3>
                            <p class="text-sm text-blue-600">Monitor ticket sales and revenue growth</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ route('event-requests.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-6 px-8 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Request Your First Event
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-blue-400 hover:bg-blue-50 text-blue-700 font-bold py-6 px-8 rounded-xl transition-all duration-300 hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Browse All Events
                        </a>
                    </div>
                </div>
                @endif
            </div>

            {{-- ================= EVENTS TAB ================= --}}
            <div id="events-tab" class="tab-content animate-fadeIn">
                {{-- ================= GOOGLE MAPS WITH EVENT MARKERS ================= --}}
                <div class="bg-white rounded-3xl shadow-sm p-6 border border-blue-50 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-blue-900">Find Events Near You</h3>
                                <p class="text-sm text-blue-600" id="map-event-count">Discovering events with valid locations...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div id="map" class="w-full h-[500px] rounded-2xl border-2 border-blue-100 overflow-hidden shadow-inner relative bg-blue-50">
                        <!-- Loading indicator -->
                        <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-blue-50">
                            <div class="text-center p-8">
                                <svg class="w-16 h-16 text-blue-500 mx-auto mb-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-blue-800 mb-2">Loading Map...</h4>
                                <p class="text-sm text-blue-600">Please wait while we load the events map</p>
                            </div>
                        </div>
                        
                        @if(!config('services.google_maps.api_key'))
                        <div class="absolute inset-0 flex items-center justify-center bg-blue-50 z-10">
                            <div class="text-center p-8">
                                <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-blue-800 mb-4">Google Maps API Key Required</h4>
                                <p class="text-sm text-blue-600 mb-4">To view events on the map, please add your Google Maps API key to the .env file.</p>
                                <code class="text-xs bg-blue-50 px-3 py-1 rounded">GOOGLE_MAPS_API_KEY=your_key_here</code>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center gap-6 text-sm text-blue-600">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                                <span>Featured Events</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                <span>Regular Events</span>
                            </div>
                        </div>
                        <button onclick="centerMapOnUserLocation()" class="px-4 py-6 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-sm transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Center on Me
                        </button>
                    </div>
                </div>

                {{-- ================= FEATURED EVENTS ================= --}}
                @if($featuredEvents->count())
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-blue-50 animate-fadeInUp animate-on-scroll">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-blue-900">
                        Featured Events
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                            <h4 class="text-xl text-blue-700 mb-3 pr-20 leading-tight font-bold
                                       group-hover:text-blue-600 transition-colors duration-300">
                                {{ $event->name }}
                            </h4>

                            <p class="text-sm text-blue-600 leading-relaxed mb-4 line-clamp-2">
                                {{ Str::limit($event->description, 80) }}
                            </p>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-blue-700 group-hover:translate-x-1 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-blue-700 group-hover:translate-x-1 transition-transform duration-300" style="transition-delay: 50ms">
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
                                      text-blue-700 px-6 py-3.5 rounded-xl font-bold
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
                      class="space-y-4">

                    {{-- Primary Search Row --}}
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-1 relative group">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-sky-400 group-focus-within:text-sky-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search"
                                   value="{{ $currentSearch }}"
                                   placeholder="Search events by name, description, or venue..."
                                   class="w-full pl-12 pr-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                          focus:ring-4 focus:ring-sky-100 focus:border-blue-200 placeholder-slate-400 text-blue-700
                                          transition-all duration-300 text-sm">
                        </div>

                        <select name="category"
                                class="px-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                       focus:ring-4 focus:ring-sky-100 focus:border-blue-200 text-blue-700
                                       transition-all duration-300 text-sm font-medium hover:border-blue-200">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ $currentCategory==$category->id?'selected':'' }}
                                    style="color: {{ $category->color }}">
                                @if($category->icon)
                                    {{ $category->name }}
                                @else
                                    {{ $category->name }}
                                @endif
                            </option>
                            @endforeach
                        </select>

                        <select name="type"
                                class="px-5 py-4 rounded-2xl border-2 border-blue-100 bg-white
                                       focus:ring-4 focus:ring-sky-100 focus:border-blue-200 text-blue-700
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

                        @if($currentSearch || $currentCategory || $currentType || request('date_from') || request('date_to') || request('price_min') || request('price_max') || request('location'))
                        <a href="{{ route('user.dashboard') }}"
                           class="bg-blue-700/50 hover:bg-blue-600/50 text-blue-100 border border-blue-500/30
                                  px-6 py-4 rounded-xl font-bold transition-all duration-300
                                  flex items-center justify-center gap-2 backdrop-blur-sm hover:scale-105 hover:-translate-y-0.5
                                  shadow-[0_4px_12px_rgba(126,34,206,0.3)] hover:shadow-[0_8px_20px_rgba(126,34,206,0.4)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </a>
                        @endif
                    </div>

                    {{-- Advanced Filters Toggle --}}
                    <div x-data="{ showAdvanced: {{ request('date_from') || request('date_to') || request('price_min') || request('price_max') || request('location') ? 'true' : 'false' }} }">
                        <button type="button" @click="showAdvanced = !showAdvanced"
                                class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                            <svg class="w-4 h-4 transition-transform duration-200" :class="showAdvanced ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <span x-text="showAdvanced ? 'Hide Advanced Filters' : 'Show Advanced Filters'"></span>
                        </button>

                        {{-- Advanced Filters Panel --}}
                        <div x-show="showAdvanced" x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0" 
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="mt-4 pt-4 border-t border-blue-100">
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Date Range --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-blue-700">Date Range</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                                   class="w-full px-3 py-6 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 text-sm">
                                        </div>
                                        <div class="relative">
                                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                                   class="w-full px-3 py-6 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 text-sm">
                                        </div>
                                    </div>
                                </div>

                                {{-- Price Range --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-blue-700">Price Range ($)</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min"
                                                   min="0" step="0.01"
                                                   class="w-full px-3 py-6 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 text-sm">
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max"
                                                   min="0" step="0.01"
                                                   class="w-full px-3 py-6 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 text-sm">
                                        </div>
                                    </div>
                                </div>

                                {{-- Location Filter --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-blue-700">Location</label>
                                    <div class="relative">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <input type="text" name="location" value="{{ request('location') }}" placeholder="City, venue, or address..."
                                               class="w-full pl-10 pr-3 py-6 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-10">
                <h3 class="text-4xl font-black text-blue-900 text-center tracking-tight">
                    Available Events
                </h3>
            </div>
                
            <!-- ADD YOUR EVENTS LISTING HERE -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($availableEvents as $event)
            <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 animate-fadeInUp flex flex-col" style="animation-delay: {{ $loop->index * 0.1 }}s; height: 520px;">
                    
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
                    <h4 class="text-xl text-blue-700 font-bold leading-tight line-clamp-2 mb-3" style="height: 56px;">
                        {{ $event->name }}
                    </h4>

                    <!-- Description -->
                    <p class="text-sm text-blue-600 leading-relaxed line-clamp-3 mb-4" style="height: 63px;">
                        {{ $event->description }}
                    </p>

                    <!-- Event Details -->
                    <div class="mb-4 flex-shrink-0" style="height: 50px;">
                        <!-- Date -->
                        <div class="flex items-center gap-2 text-sm text-blue-600 mb-4" style="height: 20px;">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium text-xs truncate">
                                {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        
                        <!-- Venue -->
                        <div class="flex items-center gap-2 text-sm text-blue-600" style="height: 20px;">
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
                                                         text-blue-700 px-4 py-2.5 rounded-xl font-bold text-sm
                                                         shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-4 h-4 {{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'text-blue-500' : 'text-blue-300' }}" fill="{{ auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
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
                    <h3 class="text-xl font-bold text-blue-900 mb-4">My Tickets ({{ $myTickets->count() }})</h3>
                    
                    @if($myTickets->count() > 0)
                    <div class="space-y-4">
                        @foreach($myTickets as $booking)
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4
                                    border border-blue-50 p-6 rounded-2xl
                                    hover:shadow-lg hover:scale-[1.02] hover:border-blue-200
                                    transition-all duration-500 bg-white
                                    group animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-black mb-3 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $booking->event->name }}
                                </p>
                                <p class="text-sm text-blue-800 mb-3">
                                    Ticket Type: <span class="font-semibold text-black">{{ $booking->ticket->type }}</span>
                                </p>
                                <p class="text-sm text-blue-800">
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
                                    {{ $booking->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-blue-100 text-blue-600' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="text-center py-6 bg-blue-50 rounded-lg">
                            <p class="text-blue-600">No tickets purchased yet. <a href="#events" class="text-blue-600 font-bold">Browse events</a> to get started!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================= FAVORITES TAB ================= --}}
            <div id="favorites-tab" class="tab-content hidden animate-fadeIn">
                <div class="">
                    <h3 class="text-xl font-bold text-blue-800">My Favorites</h3>

                    @if($myFavorites->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                    <p class="text-sm text-blue-800 leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit($event->description, 80) }}
                    </p>

                    <div class="space-y-2 mb-4">
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
                        <div class="text-center py-4">
                            <div class="p-6 bg-gradient-to-r from-sky-100/40 to-blue-100/40 rounded-3xl inline-block mb-4 border border-blue-50">
                                <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold text-blue-800 mb-4">No Favorites Yet</h4>
                            <p class="text-blue-600 text-lg mb-4">Start adding events to your favorites to see them here</p>
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
                            <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-2xl p-6 shadow-lg border border-blue-100">
                                <!-- Calendar Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-3xl font-black text-blue-800" id="calendar-month"></h3>
                                    <div class="flex gap-2">
                                        <button onclick="previousMonth()" class="p-3 bg-white hover:bg-blue-50 text-blue-600 rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg border border-blue-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="goToToday()" class="px-4 py-6 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg">
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
                                    <div class="text-center font-black text-sm text-blue-600 py-3">SUN</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">MON</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">TUE</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">WED</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">THU</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">FRI</div>
                                    <div class="text-center font-black text-sm text-blue-600 py-3">SAT</div>
                                </div>
                                
                                <!-- Calendar Grid -->
                                <div id="calendar" class="grid grid-cols-7 gap-2">
                                    <!-- Calendar will be populated by JavaScript -->
                                </div>

                                <!-- Selected Date Info -->
                                <div id="selected-date-info" class="mt-6 pt-6 border-t border-blue-200">
                                    <p class="text-center text-sm text-blue-500">Click on a date to view events for that day</p>
                                </div>

                                <!-- Legend -->
                                <div class="mt-4 flex items-center justify-center gap-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <span class="text-sm text-blue-600 font-medium">Today / Selected</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-200"></div>
                                        <span class="text-sm text-blue-600 font-medium">Has Events</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Events for Selected Date Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-blue-100 sticky top-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="p-2 bg-blue-500 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-lg text-blue-800" id="sidebar-title">All Events</h4>
                                </div>
                                <div id="events-list" class="space-y-3 max-h-[600px] overflow-y-auto">
                                    @forelse($availableEvents->sortBy('date')->take(10) as $event)
                                        @if($event->date && \Carbon\Carbon::parse($event->date)->isFuture())
                                        <div class="group p-4 bg-gradient-to-br from-blue-50 to-white hover:from-blue-100 hover:to-blue-50 rounded-xl transition-all duration-300 border border-blue-200 hover:shadow-md" data-event-date="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}">
                                            <div class="flex items-start justify-between mb-4">
                                                <p class="font-bold text-blue-800 text-sm line-clamp-2 flex-1">{{ $event->name }}</p>
                                                <span class="ml-2 px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                                                    {{ \Carbon\Carbon::parse($event->date)->format('M d') }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-blue-600 mb-3">
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
                                        <div class="text-center py-4">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-blue-600 text-sm">No upcoming events</p>
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
    
    <!-- Mobile Floating Action Button - Only visible on mobile -->
    <div class=\"fixed bottom-6 right-6 z-50 sm:hidden\">
        <a href=\"{{ route('event-requests.create') }}\"
           class=\"group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 
                  text-white w-14 h-14 rounded-full shadow-2xl hover:shadow-xl 
                  flex items-center justify-center transition-all duration-300 
                  hover:scale-110 active:scale-95 btn-no-select\"
           aria-label=\"Request Event\">
            <svg class=\"w-6 h-6\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6v6m0 0v6m0-6h6m-6 0H6\"></path>
            </svg>
        </a>
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
                        <p class="text-lg font-bold text-blue-600 mb-3">${formattedDate}</p>
                        <p class="text-sm text-blue-600">${totalEvents} event${totalEvents > 1 ? 's' : ''} on this date</p>
                    </div>
                `;
            } else {
                infoDiv.innerHTML = `
                    <div class="text-center">
                        <p class="text-lg font-bold text-blue-800 mb-3">${formattedDate}</p>
                        <p class="text-sm text-blue-500">No events on this date</p>
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
                    <p class="text-blue-600 text-sm mb-3">No events on this date</p>
                    <button onclick="clearDateSelection()" class="text-blue-600 hover:text-blue-700 text-sm font-bold">View All Events</button>
                `;
                eventsList.appendChild(emptyDiv);
            }
        }

        function clearDateSelection() {
            selectedDate = null;
            const infoDiv = document.getElementById('selected-date-info');
            infoDiv.innerHTML = '<p class="text-center text-sm text-blue-500">Click on a date to view events for that day</p>';
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
                day.className = 'relative text-center p-6 rounded-xl cursor-pointer min-h-16 flex flex-col items-center justify-center transition-all duration-300';
                day.onclick = () => isCurrentMonth && selectDate(dateString);

                if (isCurrentMonth) {
                    if (isToday || isSelected) {
                        day.classList.add('bg-blue-500', 'text-white', 'font-black', 'shadow-lg', 'scale-105', 'ring-2', 'ring-blue-300', 'hover:bg-blue-600');
                    } else if (hasEvent) {
                        day.classList.add('bg-blue-100', 'text-blue-900', 'font-bold', 'border-2', 'border-blue-400', 'hover:bg-blue-200', 'hover:scale-105', 'hover:shadow-md');
                    } else {
                        day.classList.add('bg-white', 'text-blue-800', 'font-semibold', 'border', 'border-blue-100', 'hover:bg-blue-50', 'hover:border-blue-300', 'hover:scale-105');
                    }
                } else {
                    day.classList.add('text-gray-400', 'bg-blue-50', 'cursor-not-allowed');
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
                    link.classList.add('text-blue-900', 'bg-white', 'hover:bg-blue-50');
                });

                // Show selected tab
                const selectedTab = document.getElementById(`${tabName}-tab`);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }

                // Activate selected link
                const activeLink = document.querySelector(`.tab-link[data-tab="${tabName}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-blue-900', 'bg-white', 'hover:bg-blue-50');
                    activeLink.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-500/20', 'scale-105');
                }

                // Initialize calendar if calendar tab is opened
                if (tabName === 'calendar') {
                    setTimeout(() => {
                        renderCalendar();
                    }, 50);
                }
                
                // Initialize map if events tab is opened
                if (tabName === 'events') {
                    setTimeout(() => {
                        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                            if (!map) {
                                initMap();
                            }
                        }
                    }, 100);
                }
                
                // Initialize charts if analytics tab is opened
                if (tabName === 'analytics') {
                    setTimeout(() => {
                        initAnalyticsCharts();
                    }, 100); // Small delay to ensure DOM elements are visible
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

    {{-- ================= INTERACTIVE CHARTS JAVASCRIPT ================= --}}
    <script>
        // Initialize charts function
        function initAnalyticsCharts() {
            // Chart.js default configuration
            Chart.defaults.responsive = true;
            Chart.defaults.maintainAspectRatio = false;
            Chart.defaults.plugins.legend.display = true;
            Chart.defaults.plugins.legend.position = 'bottom';
            
            // Data from backend
            const monthlyBookings = @json($monthlyBookings);
            const monthlySpending = @json($monthlySpending);
            const categoryStats = @json($categoryStats);
            const hasCreatedEvents = @json($hasCreatedEvents);
            const creatorAnalytics = @json($creatorAnalytics);
            
            // Activity Chart
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx) {
                new Chart(activityCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyBookings.map(item => item.month),
                        datasets: [{
                            label: 'Events Booked',
                            data: monthlyBookings.map(item => item.bookings),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: '#6B7280'
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#6B7280'
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#374151',
                                    font: {
                                        weight: '600'
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }

            // Spending Chart
            const spendingCtx = document.getElementById('spendingChart');
            if (spendingCtx) {
                new Chart(spendingCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlySpending.map(item => item.month),
                        datasets: [{
                            label: 'Amount Spent ($)',
                            data: monthlySpending.map(item => item.spending),
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(168, 85, 247, 0.8)',
                                'rgba(249, 115, 22, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(6, 182, 212, 0.8)'
                            ],
                            borderColor: [
                                'rgb(34, 197, 94)',
                                'rgb(59, 130, 246)',
                                'rgb(168, 85, 247)',
                                'rgb(249, 115, 22)',
                                'rgb(239, 68, 68)',
                                'rgb(6, 182, 212)'
                            ],
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value;
                                    },
                                    color: '#6B7280'
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#6B7280'
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#374151',
                                    font: {
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': $' + context.parsed.y.toFixed(2);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Category Preferences Chart (Doughnut)
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx && categoryStats.length > 0) {
                const colors = [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(156, 163, 175, 0.8)'
                ];

                const borderColors = [
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(168, 85, 247)',
                    'rgb(249, 115, 22)',
                    'rgb(239, 68, 68)',
                    'rgb(6, 182, 212)',
                    'rgb(236, 72, 153)',
                    'rgb(156, 163, 175)'
                ];

                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryStats.map(item => item.category),
                        datasets: [{
                            data: categoryStats.map(item => item.count),
                            backgroundColor: colors.slice(0, categoryStats.length),
                            borderColor: borderColors.slice(0, categoryStats.length),
                            borderWidth: 2,
                            hoverBorderWidth: 3,
                        }]
                    },
                    options: {
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#374151',
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const category = categoryStats[context.dataIndex];
                                        return context.label + ': ' + context.parsed + ' events ($' + category.spending + ')';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Creator Analytics Charts (only if user has created events)
            if (hasCreatedEvents && creatorAnalytics) {
                // Creator Events Chart
                const creatorEventsCtx = document.getElementById('creatorEventsChart');
                if (creatorEventsCtx && creatorAnalytics.monthly_created_events) {
                    new Chart(creatorEventsCtx, {
                        type: 'bar',
                        data: {
                            labels: creatorAnalytics.monthly_created_events.map(item => item.month),
                            datasets: [{
                                label: 'Events Created',
                                data: creatorAnalytics.monthly_created_events.map(item => item.events),
                                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                                borderColor: 'rgb(34, 197, 94)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6B7280'
                                    },
                                    grid: {
                                        color: 'rgba(107, 114, 128, 0.1)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#6B7280'
                                    },
                                    grid: {
                                        color: 'rgba(107, 114, 128, 0.1)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#374151',
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Creator Registrations Chart
                const creatorRegistrationsCtx = document.getElementById('creatorRegistrationsChart');
                if (creatorRegistrationsCtx && creatorAnalytics.monthly_registrations) {
                    new Chart(creatorRegistrationsCtx, {
                        type: 'line',
                        data: {
                            labels: creatorAnalytics.monthly_registrations.map(item => item.month),
                            datasets: [{
                                label: 'Registrations',
                                data: creatorAnalytics.monthly_registrations.map(item => item.registrations),
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: 'rgb(59, 130, 246)',
                                pointBorderColor: 'white',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6B7280'
                                    },
                                    grid: {
                                        color: 'rgba(107, 114, 128, 0.1)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#6B7280'
                                    },
                                    grid: {
                                        color: 'rgba(107, 114, 128, 0.1)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#374151',
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });
                }
            }
        }

        // Initialize charts when DOM is ready (for immediate display if analytics tab is active)
        document.addEventListener('DOMContentLoaded', function() {
            // Check if analytics tab is currently visible and initialize charts if needed
            const analyticsTab = document.getElementById('analytics-tab');
            if (analyticsTab && !analyticsTab.classList.contains('hidden')) {
                initAnalyticsCharts();
            }
        });
    </script>

    {{-- ================= GOOGLE MAPS INTEGRATION ================= --}}
    <script>
        let map;
        let markers = [];
        let userMarker = null;
        let infoWindow;

        // Event data with locations from Laravel - Only events with valid coordinates
        const eventLocations = [
            @foreach($availableEvents->filter(function($event) {
                // Get latitude and longitude
                $lat = null;
                $lng = null;
                
                if ($event->venue) {
                    $lat = $event->venue->latitude ?? null;
                    $lng = $event->venue->longitude ?? null;
                }
                
                // Fallback to event's own coordinates if venue doesn't have them
                if (!$lat || !$lng) {
                    $lat = $event->latitude ?? null;
                    $lng = $event->longitude ?? null;
                }
                
                // Only include events with valid, non-zero coordinates
                return $lat && $lng && 
                       is_numeric($lat) && is_numeric($lng) &&
                       abs($lat) > 0.0001 && abs($lng) > 0.0001 &&
                       abs($lat) <= 90 && abs($lng) <= 180;
            }) as $event)
            @php
                $lat = $event->venue ? ($event->venue->latitude ?? $event->latitude ?? 0) : ($event->latitude ?? 0);
                $lng = $event->venue ? ($event->venue->longitude ?? $event->longitude ?? 0) : ($event->longitude ?? 0);
            @endphp
            {
                id: {{ $event->id }},
                name: @json($event->name),
                date: @json($event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'TBD'),
                location: @json($event->venue ? $event->venue->name : ($event->location ?? 'Location TBD')),
                category: @json($event->category->name ?? 'General'),
                is_featured: {{ $event->is_featured ? 'true' : 'false' }},
                latitude: {{ $lat }},
                longitude: {{ $lng }},
                url: @json(route('events.show', $event)),
                price: @json($event->price ? '$' . number_format($event->price, 2) : 'Free'),
                venue_name: @json($event->venue ? $event->venue->name : 'TBD'),
                address: @json($event->venue ? ($event->venue->address ?? 'Address not available') : ($event->location ?? 'Location TBD'))
            },
            @endforeach
        ];

        console.log('Initializing Google Maps with', eventLocations.length, 'event locations');
        
        // Update event count in the UI
        const updateEventCount = (count) => {
            const countElement = document.getElementById('map-event-count');
            if (countElement) {
                const eventWord = count === 1 ? 'event' : 'events';
                countElement.textContent = `${count} ${eventWord} with valid locations displayed on the map`;
            }
        };
        
        // Make initMap globally accessible for Google Maps callback
        window.initMap = function() {
            console.log('initMap called - starting map initialization');
            
            // Hide loading indicator
            const loadingDiv = document.getElementById('map-loading');
            if (loadingDiv) {
                loadingDiv.style.display = 'none';
            }
            
            // Default center (you can change this to your preferred location)
            const defaultCenter = { lat: 40.7128, lng: -74.0060 }; // New York City
            
            // Initialize map
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultCenter,
                zoom: 12,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ],
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true,
            });

            infoWindow = new google.maps.InfoWindow();

            console.log('Adding markers for', eventLocations.length, 'events with valid locations');

            // Add markers for each event with valid coordinates
            let validMarkerCount = 0;
            eventLocations.forEach((event, index) => {
                // Double-check coordinates are valid
                const lat = parseFloat(event.latitude);
                const lng = parseFloat(event.longitude);
                
                if (!isNaN(lat) && !isNaN(lng) && 
                    Math.abs(lat) > 0.0001 && Math.abs(lng) > 0.0001 &&
                    Math.abs(lat) <= 90 && Math.abs(lng) <= 180) {
                    
                    const position = { lat: lat, lng: lng };
                    
                    console.log(`Marker ${index + 1}: ${event.name} at (${lat}, ${lng})`);
                    
                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: event.name,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: event.is_featured ? '#3B82F6' : '#10B981',
                            fillOpacity: 0.95,
                            strokeColor: '#ffffff',
                            strokeWeight: 2,
                        },
                        animation: google.maps.Animation.DROP,
                    });

                    // Info window content with event details
                    const contentString = `
                        <div style="padding: 12px; max-width: 280px;">
                            <h3 style="font-weight: bold; color: #1e40af; margin-bottom: 8px; font-size: 16px;">${event.name}</h3>
                            <div style="space-y: 4px; color: #4b5563; font-size: 14px;">
                                <p style="margin: 4px 0;"><strong>📅</strong> ${event.date}</p>
                                <p style="margin: 4px 0;"><strong>📍</strong> ${event.venue_name}</p>
                                <p style="margin: 4px 0;"><strong>🗺️</strong> ${event.address}</p>
                                <p style="margin: 4px 0;"><strong>🏷️</strong> ${event.category}</p>
                                <p style="margin: 4px 0;"><strong>💵</strong> ${event.price}</p>
                                ${event.is_featured ? '<p style="margin: 4px 0; color: #3b82f6; font-weight: bold;">⭐ Featured Event</p>' : ''}
                            </div>
                            <a href="${event.url}" 
                               style="display: inline-block; margin-top: 12px; padding: 8px 16px; 
                                      background: linear-gradient(to right, #3b82f6, #2563eb);
                                      color: white; text-decoration: none; border-radius: 8px; 
                                      font-weight: 600; font-size: 14px; text-align: center; width: 100%;">
                                View Details →
                            </a>
                        </div>
                    `;

                    marker.addListener('click', () => {
                        infoWindow.setContent(contentString);
                        infoWindow.open(map, marker);
                    });

                    markers.push(marker);
                    validMarkerCount++;
                } else {
                    console.warn(`Skipped invalid coordinates for event: ${event.name} (${event.latitude}, ${event.longitude})`);
                }
            });

            console.log(`Successfully added ${validMarkerCount} markers to the map`);

            // Show message if no events with locations
            if (validMarkerCount === 0) {
                const noEventsDiv = document.getElementById('map-loading');
                if (noEventsDiv) {
                    noEventsDiv.style.display = 'flex';
                    noEventsDiv.innerHTML = `
                        <div class="text-center p-8">
                            <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <h4 class="text-lg font-bold text-blue-800 mb-2">No Events with Locations</h4>
                            <p class="text-sm text-blue-600">Events will appear here once they have valid venue locations</p>
                        </div>
                    `;
                }
            }

            // If there are markers, fit bounds to show all
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => bounds.extend(marker.getPosition()));
                map.fitBounds(bounds);
                
                // Ensure zoom isn't too close
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (map.getZoom() > 15) {
                        map.setZoom(15);
                    }
                });
            }

            // Update the event count display
            updateEventCount(validMarkerCount);

            // Try to center on user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userPos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Add user location marker
                        userMarker = new google.maps.Marker({
                            position: userPos,
                            map: map,
                            title: 'Your Location',
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 8,
                                fillColor: '#EF4444',
                                fillOpacity: 1,
                                strokeColor: '#ffffff',
                                strokeWeight: 3,
                            },
                        });

                        // Center map on user if no events
                        if (markers.length === 0) {
                            map.setCenter(userPos);
                            map.setZoom(12);
                        }
                    },
                    () => {
                        console.log('Geolocation permission denied or unavailable');
                    }
                );
            }
        }

        function centerMapOnUserLocation() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            // Show loading state
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Locating...
            `;

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userPos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    // Center map on user location
                    map.setCenter(userPos);
                    map.setZoom(14);

                    // Update or create user marker with animation
                    if (userMarker) {
                        userMarker.setPosition(userPos);
                        userMarker.setAnimation(google.maps.Animation.BOUNCE);
                        setTimeout(() => userMarker.setAnimation(null), 2000);
                    } else {
                        userMarker = new google.maps.Marker({
                            position: userPos,
                            map: map,
                            title: 'Your Location',
                            animation: google.maps.Animation.DROP,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 10,
                                fillColor: '#EF4444',
                                fillOpacity: 1,
                                strokeColor: '#ffffff',
                                strokeWeight: 3,
                            },
                        });
                        
                        // Bounce animation
                        setTimeout(() => {
                            userMarker.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(() => userMarker.setAnimation(null), 2000);
                        }, 100);
                    }

                    // Calculate distances to nearby events
                    const nearbyEvents = [];
                    eventLocations.forEach(event => {
                        if (event.latitude && event.longitude && event.latitude !== 0 && event.longitude !== 0) {
                            const distance = calculateDistance(
                                userPos.lat, userPos.lng,
                                event.latitude, event.longitude
                            );
                            nearbyEvents.push({ ...event, distance });
                        }
                    });

                    // Sort by distance and get closest 3
                    nearbyEvents.sort((a, b) => a.distance - b.distance);
                    const closest = nearbyEvents.slice(0, 3);

                    // Build info window content with nearby events
                    let infoContent = '<div style="padding: 12px; min-width: 250px;">';
                    infoContent += '<h3 style="font-weight: bold; color: #EF4444; margin-bottom: 8px; font-size: 16px;">📍 You are here</h3>';
                    
                    if (closest.length > 0) {
                        infoContent += '<p style="color: #6B7280; font-size: 13px; margin: 8px 0;">Nearest events:</p>';
                        infoContent += '<div style="max-height: 200px; overflow-y: auto;">';
                        closest.forEach((event, index) => {
                            infoContent += `
                                <div style="padding: 8px; margin: 4px 0; background: #F3F4F6; border-radius: 8px;">
                                    <div style="font-weight: 600; color: #1F2937; font-size: 13px;">${event.name}</div>
                                    <div style="color: #6B7280; font-size: 12px; margin-top: 2px;">
                                        📏 ${event.distance.toFixed(1)} km away
                                    </div>
                                    <a href="${event.url}" style="color: #3B82F6; font-size: 12px; text-decoration: none; font-weight: 600;">View →</a>
                                </div>
                            `;
                        });
                        infoContent += '</div>';
                    } else {
                        infoContent += '<p style="color: #9CA3AF; font-size: 13px; margin-top: 8px;">No events found nearby</p>';
                    }
                    
                    infoContent += '</div>';

                    // Show info window
                    infoWindow.setContent(infoContent);
                    infoWindow.open(map, userMarker);

                    // Restore button
                    btn.disabled = false;
                    btn.innerHTML = originalText;

                    // Optional: Draw circle showing search radius
                    if (window.searchRadiusCircle) {
                        window.searchRadiusCircle.setMap(null);
                    }
                    window.searchRadiusCircle = new google.maps.Circle({
                        strokeColor: '#EF4444',
                        strokeOpacity: 0.3,
                        strokeWeight: 2,
                        fillColor: '#EF4444',
                        fillOpacity: 0.1,
                        map: map,
                        center: userPos,
                        radius: 5000, // 5km radius
                    });

                    // Remove circle after 3 seconds
                    setTimeout(() => {
                        if (window.searchRadiusCircle) {
                            window.searchRadiusCircle.setMap(null);
                        }
                    }, 3000);
                },
                (error) => {
                    // Restore button
                    btn.disabled = false;
                    btn.innerHTML = originalText;

                    let errorMsg = 'Unable to get your location. ';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg += 'Please enable location permissions in your browser settings.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg += 'Location information is unavailable.';
                            break;
                        case error.TIMEOUT:
                            errorMsg += 'Location request timed out.';
                            break;
                        default:
                            errorMsg += 'An unknown error occurred.';
                    }
                    alert(errorMsg);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }

        // Helper function to calculate distance between two coordinates (Haversine formula)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the Earth in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c; // Distance in km
        }
    </script>

    {{-- Load Google Maps API --}}
    @if(config('services.google_maps.api_key'))
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&callback=initMap&loading=async" async defer></script>
    @endif

</x-app-layout>







