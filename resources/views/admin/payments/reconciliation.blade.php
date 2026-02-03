<x-app-layout>
    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 py-4 sm:py-8">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-black">Payment Reconciliation</h1>
                            <p class="text-xs sm:text-sm text-gray-900">Monitor and verify payment transactions</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if(config('payments.sandbox_mode'))
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-lg">
                                🧪 SANDBOX MODE
                            </span>
                        @endif
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center px-4 py-2 border-2 border-blue-500 text-xs sm:text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 transition-all">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ================= ALERTS ================= --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- ================= STATISTICS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Payments -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-blue-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-600">Total Payments</h3>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-black text-gray-900">${{ number_format($stats['total_amount'], 2) }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $stats['total_payments'] }} transactions</p>
                </div>

                <!-- Completed -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-sm p-4 sm:p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold">Completed</h3>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-black">${{ number_format($stats['completed_amount'], 2) }}</p>
                    <p class="text-xs opacity-90 mt-1">{{ $stats['completed_payments'] }} payments</p>
                </div>

                <!-- Webhook Verified -->
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-sm p-4 sm:p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold">Verified</h3>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-black">{{ $stats['webhook_verified'] }}</p>
                    <p class="text-xs opacity-90 mt-1">{{ $stats['webhook_unverified'] }} unverified</p>
                </div>

                <!-- Refunded -->
                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-sm p-4 sm:p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold">Refunded</h3>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-black">${{ number_format($stats['refunded_amount'], 2) }}</p>
                    <p class="text-xs opacity-90 mt-1">{{ $stats['refunded_payments'] }} refunds</p>
                </div>
            </div>

            {{-- ================= FILTERS & ACTIONS ================= --}}
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-blue-50">
                <form method="GET" action="{{ route('admin.payments.reconciliation') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 text-sm">
                                Filter
                            </button>
                            <a href="{{ route('admin.payments.export', request()->query()) }}" 
                               class="px-4 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 text-sm whitespace-nowrap">
                                Export CSV
                            </a>
                        </div>
                    </div>
                </form>

                <div class="mt-4 pt-4 border-t border-gray-200 flex flex-wrap gap-2">
                    <form method="POST" action="{{ route('admin.payments.auto-reconcile') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-purple-100 text-purple-700 text-sm font-bold rounded-lg hover:bg-purple-200">
                            Auto-Reconcile
                        </button>
                    </form>
                    <a href="{{ route('admin.payments.webhook-logs') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200">
                        View Webhook Logs
                    </a>
                </div>
            </div>

            {{-- ================= UNMATCHED PAYMENTS ================= --}}
            @if($unmatchedPayments->count() > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-yellow-800">{{ $unmatchedPayments->count() }} Unverified Payments</h3>
                            <p class="text-xs text-yellow-700 mt-1">These payments have not been verified via webhook</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ================= PAYMENTS TABLE ================= --}}
            <div class="bg-white rounded-xl shadow-sm border border-blue-50 overflow-hidden">
                <div class="p-4 sm:p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                    <h3 class="text-base sm:text-lg font-bold text-black">Payment Transactions</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $payments->total() }} total payments</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Payment</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Event</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Method</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $payment->id }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->transaction_id }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->payment_date->format('M d, Y H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $payment->booking->event->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $payment->booking->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->booking->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">${{ number_format($payment->amount, 2) }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $payment->payment_method === 'virtual' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full inline-block
                                                @if($payment->status === 'completed') bg-green-100 text-green-800
                                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                            @if($payment->webhook_verified_at)
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full inline-block">
                                                    ✓ Verified
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-700 rounded-full inline-block">
                                                    ⚠ Unverified
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <div class="flex gap-1">
                                            @if(!$payment->webhook_verified_at && $payment->payment_method !== 'virtual')
                                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded hover:bg-blue-200">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('payments.show', $payment) }}" 
                                               class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded hover:bg-gray-200">
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        No payments found for the selected criteria
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payments->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
