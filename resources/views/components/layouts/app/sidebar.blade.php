<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 w-64 sidebar-transition lg:translate-x-0 transform -translate-x-full lg:relative absolute inset-y-0 left-0 z-50">
            <flux:sidebar.toggle class="lg:hidden absolute top-4 right-4 z-10" icon="x-mark" />

            <!-- Logo Section -->
            <div class="px-4 py-6 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse group" wire:navigate>
                        <div class="p-2 bg-blue-600 rounded-xl shadow-md logo-glow group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                            </svg>
                        </div>
                        <span class="text-xl font-black text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Event<span class="text-blue-600 dark:text-blue-400">Hub</span>
                        </span>
                    </a>
                    
                    <!-- Notification Bell - Users Only -->
                    @if(auth()->user()->role === 'user')
                        <div class="hidden lg:block">
                            <livewire:notification-center />
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation Content -->
            <div class="flex flex-col h-full">
                <div class="flex-1 px-4 py-6 space-y-6 overflow-y-auto sidebar-scroll">
                    <!-- Main Dashboard -->
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Overview')" class="grid">
                            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard') || request()->routeIs('user.dashboard') || request()->routeIs('admin.dashboard')" wire:navigate>
                                {{ __('Dashboard') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>

                    <!-- User Navigation (for both users and admins) -->
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Events')" class="grid">
                            @if(auth()->user()->role === 'admin')
                                <flux:navlist.item icon="calendar" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                                    {{ __('Admin Dashboard') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="calendar-days" :href="route('events.index')" :current="request()->routeIs('events.index') || request()->routeIs('events.edit') || request()->routeIs('events.show')" wire:navigate>
                                    {{ __('Manage Events') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="plus-circle" :href="route('events.create')" :current="request()->routeIs('events.create')" wire:navigate>
                                    {{ __('Create Event') }}
                                </flux:navlist.item>
                            @else
                                <flux:navlist.item icon="calendar" :href="route('user.dashboard')" :current="request()->routeIs('user.dashboard')" wire:navigate>
                                    {{ __('Browse Events') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="plus-circle" :href="route('events.create.user')" :current="request()->routeIs('events.create.user')" wire:navigate>
                                    {{ __('Create Event') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="document-text" :href="route('event-requests.index')" :current="request()->routeIs('event-requests.index')" wire:navigate>
                                    {{ __('My Event Requests') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="plus" :href="route('event-requests.create')" :current="request()->routeIs('event-requests.create')" wire:navigate>
                                    {{ __('Request Event') }}
                                </flux:navlist.item>
                            @endif
                        </flux:navlist.group>
                    </flux:navlist>

                    <!-- Bookings & Tickets -->
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Bookings & Tickets')" class="grid">
                            @if(auth()->user()->role === 'user')
                                <flux:navlist.item icon="ticket" :href="route('user.dashboard')" :current="false" wire:navigate>
                                    {{ __('My Tickets') }}
                                </flux:navlist.item>
                            @endif
                            @if(auth()->user()->role === 'admin')
                                <flux:navlist.item icon="document-text" :href="route('bookings.index')" :current="request()->routeIs('bookings.*')" wire:navigate>
                                    {{ __('All Bookings') }}
                                </flux:navlist.item>
                                <flux:navlist.item icon="currency-dollar" :href="route('payments.index')" :current="request()->routeIs('payments.*')" wire:navigate>
                                    {{ __('Payments') }}
                                </flux:navlist.item>
                            @endif
                        </flux:navlist.group>
                    </flux:navlist>

                    <!-- Admin Only Navigation -->
                    @if(auth()->user()->role === 'admin')
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Management')" class="grid">
                            <flux:navlist.item icon="clipboard-document-list" :href="route('admin.event_requests.index')" :current="request()->routeIs('admin.event_requests.*')" wire:navigate>
                                <div class="flex items-center justify-between w-full">
                                    <span>{{ __('Event Requests') }}</span>
                                    @php
                                        $pendingCount = \App\Models\EventRequest::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full notification-badge">
                                            {{ $pendingCount }}
                                        </span>
                                    @endif
                                </div>
                            </flux:navlist.item>
                            <flux:navlist.item icon="building-office" :href="route('venues.index')" :current="request()->routeIs('venues.*')" wire:navigate>
                                {{ __('Venues') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="ticket" :href="route('tickets.index')" :current="request()->routeIs('tickets.*')" wire:navigate>
                                {{ __('Tickets') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                                {{ __('Manage Users') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>

                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Analytics & Reports')" class="grid">
                            <flux:navlist.item icon="chart-bar" :href="route('attendance.index')" :current="request()->routeIs('attendance.*')" wire:navigate>
                                {{ __('Attendance') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="chat-bubble-left-right" :href="route('feedback.index')" :current="request()->routeIs('feedback.*')" wire:navigate>
                                {{ __('Feedback') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="qr-code" :href="route('attendance.scanner')" :current="request()->routeIs('attendance.scanner')" wire:navigate>
                                {{ __('QR Scanner') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>

                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Communication')" class="grid">
                            <flux:navlist.item icon="bell" :href="route('admin.notifications')" :current="request()->routeIs('admin.notifications')" wire:navigate>
                                {{ __('Notifications') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>

                    @if(auth()->user()->email === 'admin@example.com')
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Super Admin')" class="grid">
                            <flux:navlist.item icon="shield-check" :href="route('admin.management.index')" :current="request()->routeIs('admin.management.*')" wire:navigate>
                                {{ __('Admin Management') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>
                    @endif
                    @endif

                    <!-- Settings Section -->
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Settings')" class="grid">
                            <flux:navlist.item icon="user-circle" :href="route('profile.edit')" :current="request()->routeIs('profile.*')" wire:navigate>
                                {{ __('Profile') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="key" :href="route('user-password.edit')" :current="request()->routeIs('user-password.edit')" wire:navigate>
                                {{ __('Password') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="paint-brush" :href="route('appearance.edit')" :current="request()->routeIs('appearance.edit')" wire:navigate>
                                {{ __('Appearance') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>
                </div>

                <flux:spacer />

                <flux:spacer />

                <!-- User Profile Section at Bottom -->
                <div class="px-4 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    <!-- Desktop User Menu -->
                    <flux:dropdown class="hidden lg:block" position="top" align="start">
                        <flux:profile
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            icon:trailing="chevrons-up-down"
                            data-test="sidebar-menu-button"
                        />

                        <flux:menu class="w-[220px]">
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-blue-500 text-white"
                                            >
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                            <span class="truncate text-xs text-blue-600 font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </flux:sidebar>

        <!-- Mobile Header -->
        <flux:header class="lg:hidden border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 fixed top-0 left-0 right-0 z-40 h-16">
            <flux:sidebar.toggle class="lg:hidden ml-4" icon="bars-2" inset="left" />

            <div class="flex items-center space-x-3 ml-4">
                <div class="p-1.5 bg-blue-600 rounded-lg shadow-sm logo-glow">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                        <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                    </svg>
                </div>
                <span class="text-lg font-black text-zinc-900 dark:text-white">EventHub</span>
            </div>

            <!-- Mobile Notifications - Users Only -->
            @if(auth()->user()->role === 'user')
                <div class="lg:hidden">
                    <livewire:notification-center />
                </div>
            @endif

            <flux:spacer />

            <!-- Mobile User Menu -->
            <flux:dropdown position="bottom" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    size="sm"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-blue-500 text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs text-blue-600 font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Main Content Area -->
        <div class="lg:pl-64 min-h-screen bg-zinc-100 dark:bg-zinc-800 pt-16 lg:pt-0">
            <div class="main-content p-4 lg:p-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
