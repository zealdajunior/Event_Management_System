@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Event Requests Management</h2>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </a>
                </div>

                @if(session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                @if($requests->count() > 0)
                    <div class="mb-4">
                        <input id="request-search" type="text" placeholder="Search requests..." class="w-full md:w-1/2 px-4 py-3 rounded-2xl border border-blue-100 bg-white focus:ring-2 focus:ring-sky-100 focus:border-blue-200 text-sm" />
                    </div>
                    <div class="overflow-x-auto">
                        <table id="requests-table" class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Venue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($requests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $request->user->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $request->event_title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $request->venue }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($request->status === 'approved') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('event-requests.show', $request->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">
                                                View
                                            </a>
                                            @if($request->status === 'pending')
                                                <button type="button" data-action="{{ route('admin.event_requests.approve', $request->id) }}" data-title="{{ $request->event_title }}" class="open-approve-modal bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">
                                                    Approve
                                                </button>
                                                <button type="button" data-action="{{ route('admin.event_requests.reject', $request->id) }}" data-title="{{ $request->event_title }}" class="open-reject-modal bg-amber-400 hover:bg-amber-500 text-white font-bold py-1 px-2 rounded text-xs">
                                                    Reject
                                                </button>
                                            @else
                                                <span class="text-gray-500">{{ ucfirst($request->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Hidden approve form --}}
                    <form id="approve-form" method="POST" style="display:none;">
                        @csrf
                    </form>
                    {{-- Approve confirmation modal --}}
                    <div id="approve-modal" class="hidden fixed inset-0 z-50 items-center justify-center">
                        <div class="fixed inset-0 bg-black/50"></div>
                        <div class="bg-white rounded-lg p-6 z-10 max-w-md w-full">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Approve Request</h3>
                            <p id="approve-modal-title" class="text-sm text-slate-700 mb-4"></p>
                            <div class="flex justify-end gap-3">
                                <button id="approve-modal-cancel" type="button" class="px-4 py-2 rounded-lg bg-gray-100 text-slate-700">Cancel</button>
                                <button id="approve-modal-confirm" type="button" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Confirm Approve</button>
                            </div>
                        </div>
                    </div>
                    <script>
                        (function () {
                            // simple search/filter for requests table
                            const search = document.getElementById('request-search');
                            const table = document.getElementById('requests-table');
                            if (search) {
                                search.addEventListener('input', function () {
                                    const q = this.value.toLowerCase();
                                    table.querySelectorAll('tbody tr').forEach(row => {
                                        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
                                    });
                                });
                            }

                            // Approve modal logic
                            const modal = document.getElementById('approve-modal');
                            const modalTitle = document.getElementById('approve-modal-title');
                            const approveForm = document.getElementById('approve-form');
                            document.querySelectorAll('.open-approve-modal').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const action = this.getAttribute('data-action');
                                    const title = this.getAttribute('data-title') || 'this request';
                                    approveForm.setAttribute('action', action);
                                    modalTitle.textContent = 'Approve ' + title + '? This will create an event based on the request.';
                                    modal.classList.remove('hidden');                                modal.classList.add('flex');                                });
                            });

                            document.getElementById('approve-modal-cancel')?.addEventListener('click', function () {
                                modal.classList.add('hidden');
                                modal.classList.remove('flex');
                            });

                            document.getElementById('approve-modal-confirm')?.addEventListener('click', function () {
                                approveForm.submit();
                            });

                            // Reject modal logic
                            const rejectModal = document.getElementById('reject-modal');
                            const rejectModalTitle = document.getElementById('reject-modal-title');
                            const rejectForm = document.getElementById('reject-form');
                            document.querySelectorAll('.open-reject-modal').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const action = this.getAttribute('data-action');
                                    const title = this.getAttribute('data-title') || 'this request';
                                    rejectForm.setAttribute('action', action);
                                    rejectModalTitle.textContent = 'Reject ' + title + '? This will mark the request as rejected.';
                                    document.getElementById('rejection-reason').value = '';
                                    rejectModal.classList.remove('hidden');
                                    rejectModal.classList.add('flex');
                                });
                            });
                            document.getElementById('reject-modal-cancel')?.addEventListener('click', function () {
                                rejectModal.classList.add('hidden');
                                rejectModal.classList.remove('flex');
                            });
                            document.getElementById('reject-modal-confirm')?.addEventListener('click', function () {
                                const reason = document.getElementById('rejection-reason').value.trim();
                                if (!reason) {
                                    alert('Please provide a reason for rejection.');
                                    return;
                                }
                                document.getElementById('rejection-reason-input').value = reason;
                                rejectForm.submit();
                            });

                            // Delete modal logic
                            const deleteModal = document.getElementById('delete-modal');
                            const deleteModalTitle = document.getElementById('delete-modal-title');
                            const deleteForm = document.getElementById('delete-form');
                            document.querySelectorAll('.open-delete-modal').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const action = this.getAttribute('data-action');
                                    const title = this.getAttribute('data-title') || 'this request';
                                    deleteForm.setAttribute('action', action);
                                    deleteModalTitle.textContent = 'Delete ' + title + '? This is irreversible and will permanently remove the request.';
                                    deleteModal.classList.remove('hidden');
                                    deleteModal.classList.add('flex');
                                });
                            });
                            document.getElementById('delete-modal-cancel')?.addEventListener('click', function () {
                                deleteModal.classList.add('hidden');
                                deleteModal.classList.remove('flex');
                            });
                            document.getElementById('delete-modal-confirm')?.addEventListener('click', function () {
                                deleteForm.submit();
                            });

                            // close modals on Escape
                            document.addEventListener('keydown', function (e) {
                                if (e.key === 'Escape') {
                                    [modal, rejectModal, deleteModal].forEach(m => {
                                        m?.classList.add('hidden');
                                        m?.classList.remove('flex');
                                    });
                                }
                            });
                        })();
                    </script>

                    {{-- Hidden reject/delete forms --}}
                    <form id="reject-form" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="rejection_reason" id="rejection-reason-input">
                    </form>
                    <form id="delete-form" method="POST" style="display:none;">@csrf @method('DELETE')</form>

                    {{-- Reject modal --}}
                    <div id="reject-modal" class="hidden fixed inset-0 z-50 items-center justify-center">
                        <div class="fixed inset-0 bg-black/50"></div>
                        <div class="bg-white rounded-lg p-6 z-10 max-w-md w-full">
                            <h3 class="text-lg font-bold text-amber-700 mb-2">Reject Request</h3>
                            <p id="reject-modal-title" class="text-sm text-slate-700 mb-4"></p>
                            <textarea id="rejection-reason" class="w-full border rounded p-2 mb-4" placeholder="Enter reason for rejection (required)" rows="3"></textarea>
                            <div class="flex justify-end gap-3">
                                <button id="reject-modal-cancel" type="button" class="px-4 py-2 rounded-lg bg-gray-100 text-slate-700">Cancel</button>
                                <button id="reject-modal-confirm" type="button" class="px-4 py-2 rounded-lg bg-amber-500 text-white">Confirm Reject</button>
                            </div>
                        </div>
                    </div>

                    {{-- Delete modal --}}
                    <div id="delete-modal" class="hidden fixed inset-0 z-50 items-center justify-center">
                        <div class="fixed inset-0 bg-black/50"></div>
                        <div class="bg-white rounded-lg p-6 z-10 max-w-md w-full">
                            <h3 class="text-lg font-bold text-red-700 mb-2">Delete Request</h3>
                            <p id="delete-modal-title" class="text-sm text-slate-700 mb-4"></p>
                            <div class="flex justify-end gap-3">
                                <button id="delete-modal-cancel" type="button" class="px-4 py-2 rounded-lg bg-gray-100 text-slate-700">Cancel</button>
                                <button id="delete-modal-confirm" type="button" class="px-4 py-2 rounded-lg bg-red-600 text-white">Confirm Delete</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No event requests found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
