@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.events.approval.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Approvals
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $event->name }}</h1>
                        <p class="mt-2 text-gray-600">Review event details and verification documents</p>
                    </div>
                    @if($event->verification)
                    <div class="ml-6">
                        @php
                            $score = $event->verification->risk_score ?? 0;
                            $colorClass = $score >= 60 ? 'bg-red-100 text-red-800 border-red-200' : ($score >= 30 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-green-100 text-green-800 border-green-200');
                        @endphp
                        <div class="text-center border-2 {{ $colorClass }} rounded-lg p-4">
                            <div class="text-3xl font-bold">{{ $score }}</div>
                            <div class="text-xs font-medium uppercase">Risk Score</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Event Image -->
            @if($event->image)
            <div class="w-full h-64 bg-gray-200">
                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Event Information
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Event Date</label>
                            <p class="mt-1 text-gray-900">{{ $event->date->format('F d, Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $event->date->format('g:i A') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">End Date</label>
                            <p class="mt-1 text-gray-900">{{ $event->end_date ? $event->end_date->format('F d, Y g:i A') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Venue</label>
                            <p class="mt-1 text-gray-900">{{ $event->venue?->name ?? 'Online Event' }}</p>
                            @if($event->location)
                            <p class="text-sm text-gray-600">{{ $event->location }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1 text-gray-900">{{ $event->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Capacity</label>
                            <p class="mt-1 text-gray-900">{{ $event->capacity ?? 'Unlimited' }} attendees</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Ticket Price</label>
                            <p class="mt-1 text-gray-900">${{ number_format($event->price ?? 0, 2) }}</p>
                        </div>
                    </div>

                    @if($event->description)
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="mt-2 text-gray-700">{{ $event->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Verification Documents -->
                @if($event->verification)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Verification Documents
                    </h2>

                    <!-- Identity Verification -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            @if($event->verification->id_document_path)
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            Identity Verification
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Document Type:</span>
                                    <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $event->verification->id_document_type ?? 'N/A')) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">ID Number:</span>
                                    <p class="font-medium">{{ $event->verification->id_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @if($event->verification->id_expiry_date)
                            <div>
                                <span class="text-sm text-gray-500">Expiry Date:</span>
                                <p class="font-medium">{{ $event->verification->id_expiry_date->format('F d, Y') }}</p>
                            </div>
                            @endif
                            @if($event->verification->id_document_path)
                            <div>
                                <a href="{{ route('admin.verifications.download', ['verification' => $event->verification->id, 'type' => 'identity']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download ID Document
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Business Verification -->
                    @if($event->verification->business_name)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                            </svg>
                            Business Information
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Business Name:</span>
                                    <p class="font-medium">{{ $event->verification->business_name }}</p>
                                </div>
                                @if($event->verification->business_registration_number)
                                <div>
                                    <span class="text-sm text-gray-500">Registration Number:</span>
                                    <p class="font-medium">{{ $event->verification->business_registration_number }}</p>
                                </div>
                                @endif
                                @if($event->verification->tax_id)
                                <div>
                                    <span class="text-sm text-gray-500">Tax ID:</span>
                                    <p class="font-medium">{{ $event->verification->tax_id }}</p>
                                </div>
                                @endif
                            </div>
                            @if($event->verification->business_document_path)
                            <div>
                                <a href="{{ route('admin.verifications.download', ['verification' => $event->verification->id, 'type' => 'business']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Business Document
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Address Verification -->
                    @if($event->verification->address)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Address Verification
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div>
                                <span class="text-sm text-gray-500">Address:</span>
                                <p class="font-medium">{{ $event->verification->address }}</p>
                            </div>
                            @if($event->verification->address_proof_path)
                            <div>
                                <a href="{{ route('admin.verifications.download', ['verification' => $event->verification->id, 'type' => 'address']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Address Proof
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Permits & Venue -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Permits & Venue Verification
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Venue Verified:</span>
                                    <p class="font-medium">{{ $event->verification->venue_verified ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Has Required Permits:</span>
                                    <p class="font-medium">{{ $event->verification->has_permits ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                            @if($event->verification->venue_verification_notes)
                            <div>
                                <span class="text-sm text-gray-500">Venue Notes:</span>
                                <p class="font-medium">{{ $event->verification->venue_verification_notes }}</p>
                            </div>
                            @endif
                            @if($event->verification->permit_document_path)
                            <div>
                                <a href="{{ route('admin.verifications.download', ['verification' => $event->verification->id, 'type' => 'permit']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Permit Document
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Risk Factors -->
                    @if($event->verification->risk_factors)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Risk Factors
                        </h3>
                        <div class="bg-red-50 rounded-lg p-4">
                            <ul class="list-disc list-inside space-y-1 text-gray-700">
                                @foreach(json_decode($event->verification->risk_factors, true) as $factor)
                                <li>{{ $factor }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">No verification documents submitted yet</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Organizer Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Organizer Information</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">{{ substr($event->user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">{{ $event->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $event->user->email }}</p>
                            </div>
                        </div>

                        @if($event->verification)
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex items-center text-sm">
                                @if($event->user->email_verified_at)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                                <span class="text-gray-700">Email Verified</span>
                            </div>
                            <div class="flex items-center text-sm">
                                @if($event->verification->phone_verified)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                                <span class="text-gray-700">Phone: {{ $event->verification->phone_number ?? 'Not provided' }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-500">Member since</p>
                            <p class="font-medium text-gray-900">{{ $event->user->created_at->format('F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Events Created</p>
                            <p class="font-medium text-gray-900">{{ $event->user->events()->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Actions</h2>
                    
                    <!-- Approve Form -->
                    <form action="{{ route('admin.events.approval.approve', $event) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Approval Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Add any notes for the organizer..."></textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve Event
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.events.approval.reject', $event) }}" method="POST" x-data="{ showReject: false }">
                        @csrf
                        <button type="button" @click="showReject = !showReject" class="w-full px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Event
                        </button>

                        <div x-show="showReject" x-cloak class="mt-4 space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason *</label>
                                <textarea name="rejection_reason" rows="3" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Explain why this event is being rejected..."></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Internal Notes (Optional)</label>
                                <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="For internal use only..."></textarea>
                            </div>
                            <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700">
                                Confirm Rejection
                            </button>
                            <button type="button" @click="showReject = false" class="w-full px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Timeline</h2>
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Event Created</p>
                                <p class="text-sm text-gray-500">{{ $event->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>

                        @if($event->verification && $event->verification->submitted_at)
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2h-1.528A6 6 0 004 9.528V4z"/>
                                        <path fill-rule="evenodd" d="M8 10a4 4 0 00-3.446 6.032l-1.261 1.26a1 1 0 101.414 1.415l1.261-1.261A4 4 0 108 10zm-2 4a2 2 0 114 0 2 2 0 01-4 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Verification Submitted</p>
                                <p class="text-sm text-gray-500">{{ $event->verification->submitted_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('approvalForm', () => ({
        showReject: false
    }));
});
</script>
@endsection
