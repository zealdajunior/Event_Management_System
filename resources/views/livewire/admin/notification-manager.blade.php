<div x-data="{ activeTab: 'send' }" class="space-y-6">
    <!-- Flash Messages -->
    @if($successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg animate-fadeIn">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $successMessage }}
            </div>
        </div>
    @endif

    @if($errorMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)"
             class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg animate-fadeIn">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $errorMessage }}
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Notification Manager</h1>
                <p class="text-zinc-600 dark:text-zinc-400 mt-1">Send announcements and manage user notifications</p>
            </div>
            
            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5V9.09c0-2.78-2.22-5.09-5-5.09S5 6.31 5 9.09V12l-5 5h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-zinc-200 dark:border-zinc-700">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'send'" 
                        :class="activeTab === 'send' ? 'border-blue-500 text-blue-600' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300'"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    Send Announcements
                </button>
                <button @click="activeTab = 'bulk'" 
                        :class="activeTab === 'bulk' ? 'border-blue-500 text-blue-600' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300'"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    Bulk Notifications
                </button>
            </nav>
        </div>
    </div>

    <!-- Send Announcements Tab -->
    <div x-show="activeTab === 'send'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Send Announcement</h2>
            
            <form wire:submit="sendAnnouncement" class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Title</label>
                    <input type="text" wire:model="title" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100"
                           placeholder="Enter notification title...">
                    @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Message</label>
                    <textarea wire:model="message" rows="4"
                              class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100"
                              placeholder="Enter your announcement message..."></textarea>
                    @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Settings Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Type</label>
                        <select wire:model="notificationType" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100">
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="warning">Warning</option>
                            <option value="error">Error</option>
                        </select>
                    </div>

                    <!-- Channel -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Channel</label>
                        <select wire:model="channel" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100">
                            <option value="app">In-App Only</option>
                            <option value="email">Email Only</option>
                            <option value="both">Both</option>
                        </select>
                    </div>

                    <!-- Target -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Send To</label>
                        <select wire:model="targetRole" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100">
                            <option value="all">All Users</option>
                            <option value="user">Users Only</option>
                            <option value="admin">Admins Only</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4">
                    <button type="button" wire:click="resetForm" 
                            class="px-4 py-2 text-zinc-600 hover:text-zinc-800 transition-colors">
                        Reset Form
                    </button>
                    
                    <button type="submit" 
                            wire:loading.attr="disabled" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center">
                        <span wire:loading.remove>Send Announcement</span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Notifications Tab -->
    <div x-show="activeTab === 'bulk'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Bulk Notification Sender</h2>
            
            <form wire:submit="sendBulkNotification" class="space-y-6">
                <!-- User Selection -->
                <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                        Select Recipients
                        <span class="text-zinc-500 text-xs ml-2">({{ count($selectedUsers) }} selected)</span>
                    </label>
                    
                    <!-- Quick Selection -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" wire:click="selectAllUsers" 
                                class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                            Select All
                        </button>
                        <button type="button" wire:click="selectOnlyUsers" 
                                class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">
                            Users Only
                        </button>
                        <button type="button" wire:click="selectOnlyAdmins" 
                                class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition-colors">
                            Admins Only
                        </button>
                        <button type="button" wire:click="clearSelection" 
                                class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                            Clear All
                        </button>
                    </div>

                    <!-- User List -->
                    <div class="max-h-40 overflow-y-auto space-y-2 border border-zinc-200 dark:border-zinc-600 rounded-md p-3">
                        @forelse($allUsers as $user)
                            <label class="flex items-center space-x-3 p-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                       class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</p>
                                    <p class="text-xs text-zinc-500 truncate">{{ $user->email }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </label>
                        @empty
                            <p class="text-zinc-500 text-sm text-center py-4">No users found</p>
                        @endforelse
                    </div>
                </div>

                <!-- Notification Content -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Notification Title</label>
                        <input type="text" wire:model="bulkTitle" 
                               class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100"
                               placeholder="Enter notification title...">
                        @error('bulkTitle') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Message</label>
                        <textarea wire:model="bulkMessage" rows="3"
                                  class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100"
                                  placeholder="Enter your message..."></textarea>
                        @error('bulkMessage') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Delivery Channel</label>
                        <select wire:model="bulkChannel" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100">
                            <option value="app">In-App Only</option>
                            <option value="email">Email Only</option>
                            <option value="both">Both Channels</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Priority</label>
                        <select wire:model="bulkType" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-zinc-100">
                            <option value="info">Normal (Info)</option>
                            <option value="success">Success</option>
                            <option value="warning">Important (Warning)</option>
                            <option value="error">Urgent (Error)</option>
                        </select>
                    </div>
                </div>

                <!-- Preview -->
                @if($selectedUsers && count($selectedUsers) > 0 && $bulkTitle)
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-2">Preview</h4>
                        <div class="text-sm text-blue-700 dark:text-blue-400">
                            <p><strong>Recipients:</strong> {{ count($selectedUsers) }} user(s)</p>
                            <p><strong>Title:</strong> {{ $bulkTitle }}</p>
                            <p><strong>Channel:</strong> {{ ucfirst($bulkChannel) }}</p>
                            @if($bulkMessage)
                                <p><strong>Message:</strong> {{ Str::limit($bulkMessage, 100) }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ count($selectedUsers) }} recipient(s) selected
                    </p>
                    
                    <div class="flex space-x-3">
                        <button type="button" wire:click="resetBulkForm" 
                                class="px-4 py-2 text-zinc-600 hover:text-zinc-800 transition-colors">
                            Reset Form
                        </button>
                        
                        <button type="submit" 
                                wire:loading.attr="disabled" 
                                @if(!$selectedUsers || count($selectedUsers) === 0) disabled @endif
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                            <span wire:loading.remove>Send to {{ count($selectedUsers) }} User(s)</span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
