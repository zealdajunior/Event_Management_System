@extends('layouts.app')

@section('title', 'My Waitlists')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Waitlists</h1>
                    <p class="text-gray-600 mt-2">Track your position in event waitlists</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-indigo-600">{{ $waitlists->count() }}</div>
                    <div class="text-sm text-gray-500">Active Waitlists</div>
                </div>
            </div>
        </div>

        @if($waitlists->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Waitlists Yet</h3>
                <p class="text-gray-500 mb-6">You haven't joined any event waitlists yet.</p>
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Browse Events
                </a>
            </div>
        @else
            <!-- Waitlists Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($waitlists as $waitlistEntry)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Event Image -->
                        @if($waitlistEntry->event->featuredImage)
                            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ Storage::url($waitlistEntry->event->featuredImage->file_path) }}')"></div>
                        @else
                            <div class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Event Title -->
                            <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">
                                {{ $waitlistEntry->event->name }}
                            </h3>

                            <!-- Event Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $waitlistEntry->event->date->format('M j, Y g:i A') }}
                                </div>

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $waitlistEntry->event->location }}
                                </div>

                                @if($waitlistEntry->ticket)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a1 1 0 001 1h1a1 1 0 001-1V7a2 2 0 012-2h3zM5 19a2 2 0 002 2h3a2 2 0 002-2v-1a1 1 0 00-1-1H6a1 1 0 00-1 1v1z"></path>
                                        </svg>
                                        {{ $waitlistEntry->ticket->name }}
                                    </div>
                                @endif
                            </div>

                            <!-- Waitlist Status -->
                            @if($waitlistEntry->status === 'waiting')
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-yellow-800">Position #{{ $waitlistEntry->position }}</span>
                                    </div>
                                    <span class="text-xs text-yellow-600">Waiting</span>
                                </div>
                            @elseif($waitlistEntry->status === 'notified')
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                        <span class="text-sm font-medium text-green-800">Tickets Available!</span>
                                    </div>
                                    @if($waitlistEntry->time_remaining)
                                        <span class="text-xs text-green-600">{{ $waitlistEntry->time_remaining }} left</span>
                                    @endif
                                </div>

                                <!-- Action Buttons for Notified Status -->
                                <div class="flex gap-2">
                                    <a href="{{ route('waitlist.accept', $waitlistEntry) }}" 
                                       class="flex-1 bg-green-600 text-white text-center py-2 px-4 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                        Book Now
                                    </a>
                                    <button onclick="declineWaitlist({{ $waitlistEntry->id }})" 
                                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        Decline
                                    </button>
                                </div>
                            @elseif($waitlistEntry->status === 'expired')
                                <div class="flex items-center p-3 bg-red-50 rounded-lg mb-4">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium text-red-800">Offer Expired</span>
                                </div>
                            @elseif($waitlistEntry->status === 'converted')
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg mb-4">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium text-blue-800">Successfully Booked</span>
                                </div>
                            @endif

                            <!-- Quantity -->
                            @if($waitlistEntry->quantity > 1)
                                <div class="text-xs text-gray-500 mb-3">
                                    Requested {{ $waitlistEntry->quantity }} ticket{{ $waitlistEntry->quantity > 1 ? 's' : '' }}
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <a href="{{ route('events.show', $waitlistEntry->event) }}" 
                                   class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    View Event
                                </a>

                                @if($waitlistEntry->status === 'waiting')
                                    <button onclick="leaveWaitlist({{ $waitlistEntry->event->id }}, {{ $waitlistEntry->ticket?->id }})" 
                                            class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Leave Waitlist
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
async function leaveWaitlist(eventId, ticketId = null) {
    if (!confirm('Are you sure you want to leave this waitlist?')) return;

    try {
        const url = `/events/${eventId}/waitlist/leave`;
        const data = { ticket_id: ticketId };

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Failed to leave waitlist');
        }
    } catch (error) {
        console.error('Error leaving waitlist:', error);
        alert('An error occurred. Please try again.');
    }
}

async function declineWaitlist(waitlistId) {
    if (!confirm('Are you sure you want to decline this offer? This cannot be undone.')) return;

    try {
        const response = await fetch(`/waitlist/${waitlistId}/decline`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Failed to decline offer');
        }
    } catch (error) {
        console.error('Error declining waitlist:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
@endpush
@endsection