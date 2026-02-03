<div x-data="{ 
    open: @entangle('showDropdown'),
    unreadCount: @entangle('unreadCount')
}" 
     x-init="
        // Listen for clicks outside to close dropdown
        document.addEventListener('click', (e) => {
            if (!$el.contains(e.target)) {
                open = false;
            }
        });
     "
     class="relative">
    
    <!-- Notification Bell Button -->
    <button 
        @click="$wire.toggleDropdown()" 
        class="relative p-2 text-zinc-600 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700"
        :class="{ 'text-blue-600 dark:text-blue-400': open }"
    >
        <!-- Bell Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5V9.09c0-2.78-2.22-5.09-5-5.09S5 6.31 5 9.09V12l-5 5h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        <!-- Badge Count -->
        <span 
            x-show="unreadCount > 0" 
            x-text="unreadCount > 99 ? '99+' : unreadCount"
            class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full animate-pulse min-w-[1.25rem]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-0"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-0"
        ></span>
    </button>

    <!-- Dropdown Panel -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 top-full mt-2 w-80 max-w-sm bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 z-50 max-h-96 flex flex-col"
        @click.stop
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200 dark:border-zinc-700">
            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">Notifications</h3>
            
            @if($unreadCount > 0)
                <button 
                    wire:click="markAllAsRead" 
                    class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors"
                >
                    Mark all as read
                </button>
            @endif
        </div>

        <!-- Loading State -->
        @if($loading)
            <div class="flex items-center justify-center py-8">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">Loading notifications...</span>
            </div>
        @endif

        <!-- Notifications List -->
        @if(!$loading && count($notifications) > 0)
            <div class="flex-1 overflow-y-auto max-h-80">
                @foreach($notifications as $notification)
                    <div 
                        class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-700 last:border-b-0 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors cursor-pointer group"
                        :class="{{ $notification->is_read ? 'false' : 'true' }} ? 'bg-blue-50/50 dark:bg-blue-900/20' : ''"
                        wire:click="markAsRead({{ $notification->id }})"
                    >
                        <div class="flex items-start space-x-3">
                            <!-- Type Icon -->
                            <div class="flex-shrink-0 mt-1">
                                @php
                                    $iconColor = match($notification->type) {
                                        'success' => 'text-green-600',
                                        'warning' => 'text-yellow-600',
                                        'error' => 'text-red-600',
                                        default => 'text-blue-600'
                                    };
                                    
                                    $icon = match($notification->type) {
                                        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z',
                                        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                    };
                                @endphp
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                                </svg>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $notification->title }}
                                    </h4>
                                    
                                    <!-- Unread Indicator -->
                                    @if(!$notification->is_read)
                                        <div class="flex-shrink-0 ml-2">
                                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        </div>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1 line-clamp-2">
                                    {{ $notification->message }}
                                </p>
                                
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-zinc-500 dark:text-zinc-500">
                                        {{ $notification->time_ago }}
                                    </span>
                                    
                                    <!-- Delete Button (hidden by default, shown on hover) -->
                                    <button 
                                        wire:click.stop="deleteNotification({{ $notification->id }})"
                                        class="opacity-0 group-hover:opacity-100 text-zinc-400 hover:text-red-500 transition-all p-1 rounded"
                                        title="Delete notification"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Empty State -->
        @if(!$loading && count($notifications) === 0)
            <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                <svg class="w-12 h-12 text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5V9.09c0-2.78-2.22-5.09-5-5.09S5 6.31 5 9.09V12l-5 5h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 font-medium">No notifications yet</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">When you have new notifications, they'll appear here</p>
            </div>
        @endif

        <!-- Footer (View All Link) -->
        @if(count($notifications) > 0)
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-center">
                <a 
                    href="#" 
                    class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors"
                >
                    View all notifications
                </a>
            </div>
        @endif
    </div>
</div>
