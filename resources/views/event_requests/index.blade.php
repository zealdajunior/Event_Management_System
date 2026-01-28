@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
            <div class="p-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 mb-2">My Event Requests</h2>
                        <p class="text-gray-600">Track the status of your event creation requests</p>
                    </div>
                    <a href="{{ route('event-requests.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Request
                    </a>
                </div>

                @if($requests->count() > 0)
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($requests as $request)
                            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4 mb-3">
                                            <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $request->event_title }}</h3>
                                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $request->event_description }}</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span><span class="font-semibold">Start:</span> {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span><span class="font-semibold">End:</span> {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="truncate">{{ $request->venue }}</span>
                                            </div>
                                        </div>

                                        @if($request->status === 'rejected' && $request->rejection_reason)
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                                <div class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-semibold text-red-800 mb-1">Rejection Reason:</p>
                                                        <p class="text-sm text-red-700">{{ $request->rejection_reason }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-3 text-xs text-gray-500">
                                            <span>Submitted {{ $request->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        @if($request->status === 'pending')
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-semibold">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                Pending Review
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-100 text-blue-700 font-semibold">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-100 text-red-700 font-semibold">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rejected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="p-6 bg-blue-50 rounded-2xl inline-block mb-6">
                            <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No Event Requests Yet</h3>
                        <p class="text-gray-600 mb-6">You haven't submitted any event requests. Start by creating your first request!</p>
                        <a href="{{ route('event-requests.create') }}" 
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Your First Request
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
