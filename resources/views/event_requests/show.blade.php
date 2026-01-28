@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">{{ $request->event_title }}</h2>

            <div class="mb-4 text-sm text-gray-600">
                Requested by: <strong>{{ $request->user->name ?? 'Unknown' }}</strong>
                • Status: <span class="ml-2 font-semibold">{{ ucfirst($request->status) }}</span>
                @if($request->status === 'rejected' && $request->rejection_reason)
                    <div class="mt-2 text-red-600">Reason for rejection: {{ $request->rejection_reason }}</div>
                @endif
            </div>

            <div class="prose mb-6">{!! nl2br(e($request->event_description)) !!}</div>

            <div class="flex items-center gap-3">
                @if(auth()->user()->isAdmin() && $request->status === 'pending')
                    <button type="button" data-action="{{ route('admin.event_requests.approve', $request->id) }}" data-title="{{ $request->event_title }}" class="open-approve-modal btn-primary">Approve</button>
                    <button type="button" data-action="{{ route('admin.event_requests.reject', $request->id) }}" data-title="{{ $request->event_title }}" class="open-reject-modal btn-danger">Reject</button>
                @endif

                {{-- Hidden approve form and modal (same behavior as other pages) --}}
                <form id="approve-form" method="POST" style="display:none;">@csrf</form>
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

                {{-- Hidden reject/delete forms & modals --}}
                <form id="reject-form" method="POST" style="display:none;">
                    @csrf
                    <input type="hidden" name="rejection_reason" id="rejection-reason-input">
                </form>
                <form id="delete-form" method="POST" style="display:none;">@csrf @method('DELETE')</form>

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

                <script>
                    (function () {
                        const modal = document.getElementById('approve-modal');
                        const modalTitle = document.getElementById('approve-modal-title');
                        const approveForm = document.getElementById('approve-form');
                        document.querySelectorAll('.open-approve-modal').forEach(btn => {
                            btn.addEventListener('click', function () {
                                const action = this.getAttribute('data-action');
                                const title = this.getAttribute('data-title') || 'this request';
                                approveForm.setAttribute('action', action);
                                modalTitle.textContent = 'Approve ' + title + '? This will create an event based on the request.';
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');
                            });
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

                @if(auth()->user()->isAdmin())
                    <button type="button" data-action="{{ route('admin.event_requests.destroy', $request->id) }}" data-title="{{ $request->event_title }}" class="open-delete-modal btn-danger">Delete</button>
                @endif

                <a href="{{ url()->previous() }}" class="btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection