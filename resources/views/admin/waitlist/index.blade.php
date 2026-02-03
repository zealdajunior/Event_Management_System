@extends('layouts.app')

@section('title', 'Waitlist Management - ' . $event->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Waitlist Management</h1>
                    <p class="text-gray-600 mt-2">{{ $event->name }}</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $event->date->format('M j, Y g:i A') }} • {{ $event->location }}
                    </div>
                </div>
                <div class="text-right">
                    <button onclick="loadStatistics()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Statistics
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Panel (Initially Hidden) -->
        <div id="statisticsPanel" class="bg-white rounded-xl shadow-sm p-6 mb-8 hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Waitlist Statistics</h3>
            <div id="statisticsContent" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Statistics will be loaded here -->
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
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Waitlists</h3>
                <p class="text-gray-500">No users are currently on the waitlist for this event.</p>
            </div>
        @else
            <!-- Waitlists by Ticket Type -->
            @foreach($waitlists as $ticketId => $waitlistEntries)
                @php
                    $ticket = $tickets->find($ticketId);
                    $ticketName = $ticket ? $ticket->name : 'General Admission';
                @endphp

                <div class="bg-white rounded-xl shadow-sm mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $ticketName }}</h3>
                                <p class="text-sm text-gray-500">{{ $waitlistEntries->count() }} people waiting</p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="promoteSelected('{{ $ticketId }}')" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    Promote Selected
                                </button>
                                <button onclick="selectAll('{{ $ticketId }}')" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                    Select All
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll-{{ $ticketId }}" onchange="toggleAll('{{ $ticketId }}', this.checked)">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($waitlistEntries as $waitlistEntry)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($waitlistEntry->status === 'waiting')
                                                <input type="checkbox" name="waitlist_ids[]" value="{{ $waitlistEntry->id }}" class="waitlist-checkbox waitlist-checkbox-{{ $ticketId }}">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                #{{ $waitlistEntry->position }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">
                                                            {{ substr($waitlistEntry->user->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $waitlistEntry->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $waitlistEntry->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $waitlistEntry->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($waitlistEntry->status === 'waiting')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                                                    Waiting
                                                </span>
                                            @elseif($waitlistEntry->status === 'notified')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                                    Notified
                                                </span>
                                                @if($waitlistEntry->time_remaining)
                                                    <div class="text-xs text-gray-500 mt-1">{{ $waitlistEntry->time_remaining }} left</div>
                                                @endif
                                            @elseif($waitlistEntry->status === 'expired')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Expired
                                                </span>
                                            @elseif($waitlistEntry->status === 'converted')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Converted
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $waitlistEntry->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($waitlistEntry->status === 'waiting')
                                                <button onclick="promoteUser({{ $waitlistEntry->id }})" 
                                                        class="text-green-600 hover:text-green-700 font-medium">
                                                    Promote Now
                                                </button>
                                            @elseif($waitlistEntry->status === 'notified' && $waitlistEntry->notified_at)
                                                <div class="text-xs text-gray-500">
                                                    Notified {{ $waitlistEntry->notified_at->diffForHumans() }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')
<script>
const eventId = {{ $event->id }};

async function loadStatistics() {
    const panel = document.getElementById('statisticsPanel');
    const content = document.getElementById('statisticsContent');
    
    try {
        const response = await fetch(`/admin/events/${eventId}/waitlist/statistics`);
        const stats = await response.json();
        
        content.innerHTML = `
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">${stats.total_waiting}</div>
                <div class="text-sm text-gray-500">Waiting</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">${stats.total_notified}</div>
                <div class="text-sm text-gray-500">Notified</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">${stats.total_converted}</div>
                <div class="text-sm text-gray-500">Converted</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">${stats.total_expired}</div>
                <div class="text-sm text-gray-500">Expired</div>
            </div>
        `;
        
        panel.classList.remove('hidden');
    } catch (error) {
        console.error('Error loading statistics:', error);
        alert('Failed to load statistics');
    }
}

function toggleAll(ticketId, checked) {
    const checkboxes = document.querySelectorAll(`.waitlist-checkbox-${ticketId}`);
    checkboxes.forEach(checkbox => checkbox.checked = checked);
}

function selectAll(ticketId) {
    const selectAllCheckbox = document.getElementById(`selectAll-${ticketId}`);
    selectAllCheckbox.checked = true;
    toggleAll(ticketId, true);
}

async function promoteSelected(ticketId) {
    const checkboxes = document.querySelectorAll(`.waitlist-checkbox-${ticketId}:checked`);
    const waitlistIds = Array.from(checkboxes).map(cb => cb.value);
    
    if (waitlistIds.length === 0) {
        alert('Please select users to promote');
        return;
    }
    
    if (!confirm(`Promote ${waitlistIds.length} user(s) from waitlist?`)) return;
    
    await promoteUsers(waitlistIds);
}

async function promoteUser(waitlistId) {
    if (!confirm('Promote this user from waitlist?')) return;
    await promoteUsers([waitlistId]);
}

async function promoteUsers(waitlistIds) {
    try {
        const response = await fetch(`/admin/events/${eventId}/waitlist/promote`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ waitlist_ids: waitlistIds })
        });

        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert(result.message || 'Failed to promote users');
        }
    } catch (error) {
        console.error('Error promoting users:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
@endpush
@endsection