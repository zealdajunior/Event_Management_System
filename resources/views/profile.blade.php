<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-50 to-white rounded-2xl p-4 mb-6 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4" fill="currentColor" opacity="0.8"/>
                        <path d="M4 20c0-4 3.5-7 8-7s8 3 8 7" stroke-linecap="round"/>
                        <path d="M16 6l2-2M8 6L6 4" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-900">
                        Profile Settings
                    </h2>
                    <div class="h-1 w-20 bg-blue-500 rounded-full mt-1"></div>
                    <p class="text-gray-600 mt-1 text-sm">Manage your account information</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            <div class="p-6 bg-white shadow-lg sm:rounded-2xl">
                <div class="max-w-xl">
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                            <div class="p-1.5 bg-blue-100 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                    <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                                </svg>
                            </div>
                            Profile Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Update your account's profile information and email address.</p>
                    </div>
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-6 bg-white shadow-lg sm:rounded-2xl">
                <div class="max-w-xl">
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                            <div class="p-1.5 bg-blue-100 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="5" y="11" width="14" height="10" rx="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="16" r="1" fill="currentColor"/>
                                    <path d="M9 11V7a3 3 0 016 0v4" stroke-linecap="round"/>
                                </svg>
                            </div>
                            Update Password
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-6 bg-white shadow-lg sm:rounded-2xl">
                <div class="max-w-xl">
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                            <div class="p-1.5 bg-red-100 rounded-lg">
                                <svg class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M15 9l-6 6M9 9l6 6" stroke-linecap="round"/>
                                </svg>
                            </div>
                            Delete Account
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Permanently delete your account and all of its data.</p>
                    </div>
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
