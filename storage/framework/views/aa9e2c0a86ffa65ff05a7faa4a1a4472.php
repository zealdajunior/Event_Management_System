<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
     <?php $__env->slot('header', null, []); ?> 
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-black">Admin Dashboard</h1>
                            <p class="text-sm text-gray-900">Manage events, users, and system analytics</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 text-sm text-blue-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span>Live</span>
                        </div>

                        <a href="<?php echo e(route('events.create')); ?>"
                           class="inline-flex items-center px-5 py-2.5 border-2 border-blue-500 text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 transition-all duration-300 shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Event
                        </a>

                        <a href="<?php echo e(route('venues.create')); ?>"
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Add Venue
                        </a>
                    </div>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-gradient-to-r from-white to-blue-50 rounded-2xl shadow-sm border border-blue-50 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    $stats = [
                        ['label' => 'Total Events', 'value' => $totalEvents, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Total Users', 'value' => $totalUsers, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Pending Requests', 'value' => $pendingRequests, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Total Bookings', 'value' => $totalBookings, 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z', 'color' => 'blue', 'bgColor' => 'bg-blue-50', 'textColor' => 'text-blue-600']
                    ];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-black mb-1"><?php echo e($stat['label']); ?></p>
                                <p class="text-3xl font-bold text-black"><?php echo e($stat['value']); ?></p>
                            </div>
                            <div class="p-3 rounded-lg <?php echo e($stat['bgColor']); ?> group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 <?php echo e($stat['textColor']); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($stat['icon']); ?>"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 bg-gradient-to-r from-<?php echo e($stat['color']); ?>-200 to-<?php echo e($stat['color']); ?>-300 rounded-full"></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="grid grid-cols-2 md:grid-cols-10 gap-4">
                <?php
                $tabs = [
                    'events' => ['label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    'bookings' => ['label' => 'Bookings', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                    'users' => ['label' => 'Users', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    'revenue' => ['label' => 'Revenue', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'notifications' => ['label' => 'Alerts', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                    'emails' => ['label' => 'Emails', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    'checkin' => ['label' => 'Check-in', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'feedback' => ['label' => 'Feedback', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                    'requests' => ['label' => 'Requests', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    'analytics' => ['label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']
                ];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#<?php echo e($key); ?>" data-tab="<?php echo e($key); ?>"
                   class="tab-link py-3 px-6 text-center rounded-2xl font-bold text-gray-700
                          bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-blue-100
                          border border-gray-200 hover:border-blue-300
                          transition-all duration-300 hover:shadow-lg hover:-translate-y-1
                          flex flex-col items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($tab['icon']); ?>"></path>
                    </svg>
                    <span class="text-sm"><?php echo e($tab['label']); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div id="events-tab" class="tab-content animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Recent Events
                            </h3>
                            <p class="text-gray-600">Manage and monitor your events</p>
                        </div>
                        <a href="<?php echo e(route('events.index')); ?>"
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View All Events
                        </a>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentEvents->count() > 0): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="group relative bg-white p-6 rounded-2xl shadow-lg border border-blue-100
                                                hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-blue-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-100/30 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>
                                        <div class="relative">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                    <span class="text-xs text-gray-600 font-medium">Active</span>
                                                </div>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-300"><?php echo e($event->name); ?></h4>
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($event->description); ?></p>
                                            <div class="space-y-2 mb-6">
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span><?php echo e($event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y H:i') : 'N/A'); ?></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                    <span><?php echo e($event->venue->name ?? 'TBD'); ?></span>
                                                </div>
                                            </div>
                                            <a href="<?php echo e(route('events.show', $event)); ?>"
                                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                                      text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-500/30
                                                      hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                                <span>View Details</span>
                                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-16">
                                <div class="p-6 bg-blue-50 rounded-2xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Recent Events</h4>
                                <p class="text-gray-600 text-lg mb-6">Start creating amazing events to see them here</p>
                                <a href="<?php echo e(route('events.create')); ?>"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                          text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-blue-500/30
                                          hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Create Your First Event</span>
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div id="bookings-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Recent Bookings
                            </h3>
                            <p class="text-gray-600">Monitor ticket sales and booking activity</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="<?php echo e(route('admin.export.bookings')); ?>"
                               class="inline-flex items-center px-5 py-2.5 border-2 border-blue-500 text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 transition-all duration-300 shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] hover:scale-105 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export CSV
                            </a>
                            <a href="<?php echo e(route('bookings.index')); ?>"
                               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View All
                            </a>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentBookings->count() > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="group relative bg-white p-6 rounded-2xl shadow-lg border border-gray-100
                                            hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-blue-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-100/30 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                                        <div class="relative">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                    <span class="text-xs text-gray-600 font-medium">Confirmed</span>
                                                </div>
                                            </div>

                                            <div class="space-y-3 mb-6">
                                                <div class="flex items-center gap-2 text-sm">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span class="font-semibold text-gray-900"><?php echo e($booking->user->name); ?></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span><?php echo e($booking->event->name); ?></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                    </svg>
                                                    <span><?php echo e($booking->ticket->type); ?> - <span class="font-semibold text-blue-600">$<?php echo e($booking->ticket->price); ?></span></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span><?php echo e($booking->booking_date instanceof \Carbon\Carbon ? $booking->booking_date->format('M d, Y H:i') : date('M d, Y H:i', strtotime($booking->booking_date))); ?></span>
                                                </div>
                                            </div>

                                            <a href="<?php echo e(route('bookings.show', $booking)); ?>"
                                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                                      text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-500/30
                                                      hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                                <span>View Details</span>
                                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-16">
                                <div class="p-6 bg-blue-50 rounded-2xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Recent Bookings</h4>
                                <p class="text-gray-600 mb-6">Bookings will appear here once users start purchasing tickets</p>
                                <a href="<?php echo e(route('events.index')); ?>"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                          text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-blue-500/30
                                          hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>View Events</span>
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div id="users-tab" class="tab-content hidden animate-on-scroll">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                User Management
                            </h3>
                            <p class="text-gray-600">Monitor and manage user accounts and roles</p>
                        </div>
                        <a href="<?php echo e(route('users.index')); ?>"
                               class="group relative bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                      active:scale-95 transition-all duration-500
                                      text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-blue-500/30
                                      hover:shadow-xl hover:shadow-blue-500/50 flex items-center gap-3
                                      overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="relative z-10">Manage Users</span>
                            <div class="absolute inset-0 bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Total Users Card -->
                            <div class="group bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 text-sm font-medium mb-1">Total Users</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e($totalUsers); ?></p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-gray-600">Registered</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-blue-50 rounded-xl">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Users Card -->
                            <div class="group bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 text-sm font-medium mb-1">Admin Users</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e(\App\Models\User::where('role', 'admin')->count()); ?></p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-gray-600">Privileged</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-blue-50 rounded-xl">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Regular Users Card -->
                            <div class="group bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 text-sm font-medium mb-1">Regular Users</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e(\App\Models\User::where('role', 'user')->count()); ?></p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-gray-600">Active</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-blue-50 rounded-xl">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                            </div>
                        </div>
                    </div>

                
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentUsers && $recentUsers->count() > 0): ?>
                        <div class="mt-8">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Recent Users</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="group bg-white p-5 rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                                            <div class="flex items-start gap-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                        <?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?>

                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5 class="text-gray-900 font-bold text-sm truncate"><?php echo e($user->name ?? 'N/A'); ?></h5>
                                                    <p class="text-gray-600 text-xs truncate"><?php echo e($user->email ?? 'N/A'); ?></p>
                                                    <div class="flex items-center gap-2 mt-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e(($user->role ?? 'user') === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-blue-50 text-blue-600'); ?>">
                                                            <?php echo e(ucfirst($user->role ?? 'user')); ?>

                                                        </span>
                                                        <span class="text-gray-500 text-xs"><?php echo e($user->created_at ? $user->created_at->diffForHumans() : 'Recently'); ?></span>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div id="requests-tab" class="tab-content hidden animate-on-scroll">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Event Requests
                                    <span class="ml-3 inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">
                                        <?php echo e($eventRequests->count()); ?> Total
                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingRequests > 0): ?>
                                        <span class="ml-2 inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold">
                                            <?php echo e($pendingRequests); ?> Pending
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </h3>
                                <p class="text-sm text-gray-600">Review and manage event creation requests</p>
                            </div>
                            <a href="<?php echo e(route('admin.event_requests.index')); ?>"
                               class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                      text-white px-6 py-3 rounded-xl font-bold shadow-lg
                                      hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>View All Requests</span>
                            </a>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eventRequests && $eventRequests->count() > 0): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $eventRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="group bg-white p-6 rounded-xl shadow-md border border-gray-100
                                                hover:shadow-xl transition-all duration-300">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 <?php echo e($request->status === 'pending' ? 'bg-blue-500' : ($request->status === 'approved' ? 'bg-blue-600' : 'bg-gray-400')); ?> rounded-full"></div>
                                                <span class="text-xs text-gray-600 font-medium capitalize"><?php echo e($request->status); ?></span>
                                            </div>
                                        </div>

                                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-300"><?php echo e($request->event_title); ?></h4>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($request->event_description); ?></p>

                                        <div class="space-y-2 mb-6">
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span>By: <span class="font-semibold"><?php echo e($request->user->name); ?></span></span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span><?php echo e(\Carbon\Carbon::parse($request->start_date)->format('M d, Y')); ?></span>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->venue): ?>
                                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span><?php echo e(Str::limit($request->venue, 30)); ?></span>
                                        </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span><?php echo e($request->created_at->diffForHumans()); ?></span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 flex-wrap">
                                            <a href="<?php echo e(route('event-requests.show', $request)); ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->status === 'pending'): ?>
                                                <button type="button" data-action="<?php echo e(route('admin.event_requests.approve', $request->id)); ?>" data-title="<?php echo e($request->event_title); ?>" class="open-approve-modal inline-flex items-center gap-2 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Approve
                                                </button>
                                                <button type="button" data-action="<?php echo e(route('admin.event_requests.reject', $request->id)); ?>" data-title="<?php echo e($request->event_title); ?>" class="open-reject-modal inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Reject
                                                </button>
                                            <?php elseif($request->status === 'approved'): ?>
                                                <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-semibold text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Approved
                                                </span>
                                            <?php elseif($request->status === 'rejected'): ?>
                                                <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-semibold text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <button type="button" data-action="<?php echo e(route('admin.event_requests.destroy', $request->id)); ?>" data-title="<?php echo e($request->event_title); ?>" class="open-delete-modal-dashboard inline-flex items-center gap-2 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </div> 
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-16">
                                <div class="p-6 bg-blue-50 rounded-2xl inline-block mb-6">
                                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2">No Event Requests Yet</h4>
                                <p class="text-gray-600 mb-6">No event requests have been submitted. Check back later.</p>
                                <a href="<?php echo e(route('admin.event_requests.index')); ?>"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                                          text-white px-6 py-3 rounded-xl font-bold shadow-lg
                                          hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    View Requests Page
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-tab" class="tab-content hidden animate-on-scroll">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Analytics & Insights
                            </h3>
                            <p class="text-gray-600">Track performance metrics and business insights</p>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Revenue with Circular Progress -->
                        <div class="group bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-2xl hover:scale-105 transition-all duration-500">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="#E0E7FF" stroke-width="8" fill="none" />
                                        <circle cx="64" cy="64" r="56" stroke="#3B82F6" stroke-width="8" fill="none"
                                                stroke-dasharray="351.86"
                                                stroke-dashoffset="<?php echo e(351.86 * (1 - min(1, $totalRevenue / 100000))); ?>"
                                                stroke-linecap="round" class="transition-all duration-1000" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Revenue</p>
                                <p class="text-3xl font-black bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">$<?php echo e(number_format($totalRevenue, 2)); ?></p>
                                <p class="text-xs text-blue-600 mt-2">Completed Payments</p>
                            </div>
                        </div>

                        <!-- Upcoming Events with Circular Progress -->
                        <div class="group bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-2xl hover:scale-105 transition-all duration-500">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="#E0E7FF" stroke-width="8" fill="none" />
                                        <circle cx="64" cy="64" r="56" stroke="#2563EB" stroke-width="8" fill="none"
                                                stroke-dasharray="351.86"
                                                stroke-dashoffset="<?php echo e(351.86 * (1 - min(1, $upcomingEvents / max(1, $totalEvents)))); ?>"
                                                stroke-linecap="round" class="transition-all duration-1000" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-3xl font-black text-blue-600"><?php echo e($upcomingEvents); ?></p>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Upcoming Events</p>
                                <p class="text-xs text-blue-600 mt-2"><?php echo e($totalEvents > 0 ? round(($upcomingEvents / $totalEvents) * 100) : 0); ?>% of total</p>
                            </div>
                        </div>

                        <!-- Confirmed Bookings with Circular Progress -->
                        <div class="group bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-2xl hover:scale-105 transition-all duration-500">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="#E0E7FF" stroke-width="8" fill="none" />
                                        <circle cx="64" cy="64" r="56" stroke="#1D4ED8" stroke-width="8" fill="none"
                                                stroke-dasharray="351.86"
                                                stroke-dashoffset="<?php echo e(351.86 * (1 - min(1, $confirmedBookings / max(1, $totalBookings)))); ?>"
                                                stroke-linecap="round" class="transition-all duration-1000" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-3xl font-black text-blue-700"><?php echo e($confirmedBookings); ?></p>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Confirmed Bookings</p>
                                <p class="text-xs text-blue-600 mt-2"><?php echo e($totalBookings > 0 ? round(($confirmedBookings / $totalBookings) * 100) : 0); ?>% confirmed</p>
                            </div>
                        </div>

                        <!-- Past Events with Circular Progress -->
                        <div class="group bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-2xl hover:scale-105 transition-all duration-500">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="#E0E7FF" stroke-width="8" fill="none" />
                                        <circle cx="64" cy="64" r="56" stroke="#60A5FA" stroke-width="8" fill="none"
                                                stroke-dasharray="351.86"
                                                stroke-dashoffset="<?php echo e(351.86 * (1 - min(1, $pastEvents / max(1, $totalEvents)))); ?>"
                                                stroke-linecap="round" class="transition-all duration-1000" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-3xl font-black text-blue-400"><?php echo e($pastEvents); ?></p>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Past Events</p>
                                <p class="text-xs text-blue-600 mt-2"><?php echo e($totalEvents > 0 ? round(($pastEvents / $totalEvents) * 100) : 0); ?>% completed</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700 text-sm font-medium">Confirmed</span>
                                    <span class="text-2xl font-black text-blue-600"><?php echo e($confirmedBookings); ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($totalBookings > 0 ? ($confirmedBookings / $totalBookings * 100) : 0); ?>%"></div>
                                </div>
                            </div>
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700 text-sm font-medium">Pending</span>
                                    <span class="text-2xl font-black text-blue-500"><?php echo e($pendingBookings); ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-400 h-2 rounded-full" style="width: <?php echo e($totalBookings > 0 ? ($pendingBookings / $totalBookings * 100) : 0); ?>%"></div>
                                </div>
                            </div>
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700 text-sm font-medium">Cancelled</span>
                                    <span class="text-2xl font-black text-gray-500"><?php echo e($cancelledBookings); ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-400 h-2 rounded-full" style="width: <?php echo e($totalBookings > 0 ? ($cancelledBookings / $totalBookings * 100) : 0); ?>%"></div>
                                </div>
                            </div>
                    </div>

                
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topEvents->count() > 0): ?>
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md mb-8">
                                <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Top Events by Bookings
                                </h4>
                                <div class="space-y-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-300">
                                            <div class="flex-1">
                                                <h5 class="text-gray-900 font-bold"><?php echo e($event->title); ?></h5>
                                                <p class="text-gray-600 text-sm"><?php echo e($event->date->format('M d, Y')); ?></p>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <div class="text-right">
                                                    <p class="text-2xl font-black text-blue-600"><?php echo e($event->bookings_count); ?></p>
                                                    <p class="text-gray-600 text-xs">bookings</p>
                                                </div>
                                                <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600" style="width: <?php echo e(min(100, ($event->bookings_count / ($topEvents->max('bookings_count') ?: 1)) * 100)); ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="p-3 bg-blue-50 rounded-xl">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 text-sm">Pending Requests</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e($pendingRequests); ?></p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-xs">Awaiting admin review</p>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="p-3 bg-blue-50 rounded-xl">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 text-sm">Approved Requests</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e($approvedRequests); ?></p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-xs">Converted to events</p>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-md">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="p-3 bg-gray-100 rounded-xl">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 text-sm">Rejected Requests</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo e($rejectedRequests); ?></p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-xs">Did not meet criteria</p>
                            </div>
                    </div>

                
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentEvents->count() > 0): ?>
                            <div class="bg-white p-6 rounded-xl border border-blue-100 shadow-md">
                                <h4 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Recent Events
                                </h4>
                                <div class="space-y-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentEvents->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-gray-900 font-semibold text-sm truncate"><?php echo e($event->name); ?></p>
                                                <p class="text-gray-600 text-xs"><?php echo e($event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A'); ?></p>
                                            </div>
                                            <span class="ml-2 px-2 py-1 text-xs rounded-full font-medium <?php echo e($event->date && \Carbon\Carbon::parse($event->date) >= now() ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'); ?>">
                                                <?php echo e($event->date && \Carbon\Carbon::parse($event->date) >= now() ? 'Upcoming' : 'Past'); ?>

                                            </span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="bg-white p-6 rounded-xl border border-blue-100 shadow-md">
                            <h4 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                User Overview
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 text-sm font-medium">Total Users</span>
                                    </div>
                                    <span class="text-2xl font-black text-blue-600"><?php echo e($totalUsers); ?></span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 text-sm font-medium">Admin Users</span>
                                    </div>
                                    <span class="text-2xl font-black text-blue-600"><?php echo e(\App\Models\User::where('role', 'admin')->count()); ?></span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 text-sm font-medium">New This Week</span>
                                    </div>
                                    <span class="text-2xl font-black text-blue-600"><?php echo e(\App\Models\User::where('created_at', '>=', now()->subDays(7))->count()); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white p-6 rounded-xl border border-blue-100 shadow-md">
                        <h4 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Platform Statistics
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                                <p class="text-4xl font-black text-blue-600 mb-1"><?php echo e($totalEvents); ?></p>
                                <p class="text-gray-600 text-sm">Total Events</p>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                                <p class="text-4xl font-black text-blue-600 mb-1"><?php echo e($totalUsers); ?></p>
                                <p class="text-gray-600 text-sm">Total Users</p>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                                <p class="text-4xl font-black text-blue-600 mb-1"><?php echo e($totalBookings); ?></p>
                                <p class="text-gray-600 text-sm">Total Bookings</p>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                                <p class="text-4xl font-black text-blue-600 mb-1"><?php echo e($pendingRequests + $approvedRequests + $rejectedRequests); ?></p>
                                <p class="text-gray-600 text-sm">All Requests</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            
            <div id="revenue-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Revenue & Financial Dashboard
                            </h3>
                            <p class="text-gray-600">Track earnings, payments, and financial performance</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="<?php echo e(route('admin.export.revenue')); ?>" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export CSV
                            </a>
                            <button onclick="window.print()" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(34,197,94,0.3)] hover:shadow-[0_8px_20px_rgba(34,197,94,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>

                    <?php
                        $totalRevenue = \App\Models\Payment::where('status', 'completed')->sum('amount');
                        $thisMonthRevenue = \App\Models\Payment::where('status', 'completed')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('amount');
                        $todayRevenue = \App\Models\Payment::where('status', 'completed')
                            ->whereDate('created_at', today())
                            ->sum('amount');
                        $pendingRevenue = \App\Models\Payment::where('status', 'pending')->sum('amount');
                        $totalTransactions = \App\Models\Payment::where('status', 'completed')->count();
                        $avgTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
                    ?>

                    <!-- Revenue Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 border border-green-100">
                            <div class="flex items-center justify-between mb-3">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-1 text-sm font-semibold">Total Revenue</p>
                            <p class="text-3xl font-black text-green-600">$<?php echo e(number_format($totalRevenue, 2)); ?></p>
                            <p class="text-xs text-gray-500 mt-2">All time earnings</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                            <div class="flex items-center justify-between mb-3">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-1 text-sm font-semibold">This Month</p>
                            <p class="text-3xl font-black text-blue-600">$<?php echo e(number_format($thisMonthRevenue, 2)); ?></p>
                            <p class="text-xs text-gray-500 mt-2"><?php echo e(now()->format('F Y')); ?></p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-6 border border-purple-100">
                            <div class="flex items-center justify-between mb-3">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-1 text-sm font-semibold">Today's Revenue</p>
                            <p class="text-3xl font-black text-purple-600">$<?php echo e(number_format($todayRevenue, 2)); ?></p>
                            <p class="text-xs text-gray-500 mt-2"><?php echo e(now()->format('M d, Y')); ?></p>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 border border-orange-100">
                            <div class="flex items-center justify-between mb-3">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-1 text-sm font-semibold">Pending Payments</p>
                            <p class="text-3xl font-black text-orange-600">$<?php echo e(number_format($pendingRevenue, 2)); ?></p>
                            <p class="text-xs text-gray-500 mt-2">Awaiting completion</p>
                        </div>
                    </div>

                    <!-- Transaction Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Transactions</p>
                            <p class="text-4xl font-black text-gray-800"><?php echo e(number_format($totalTransactions)); ?></p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Average Transaction</p>
                            <p class="text-4xl font-black text-gray-800">$<?php echo e(number_format($avgTransactionValue, 2)); ?></p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Success Rate</p>
                            <p class="text-4xl font-black text-gray-800"><?php echo e($totalTransactions > 0 ? number_format(($totalTransactions / (\App\Models\Payment::count() ?: 1)) * 100, 1) : 0); ?>%</p>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-lg font-black text-gray-800 mb-4">Recent Transactions</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">Payment ID</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">User</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">Event</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">Amount</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">Status</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-600">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $recentTransactions = \App\Models\Payment::with(['booking.user', 'booking.event'])
                                            ->where('status', 'completed')
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="border-b border-gray-100 hover:bg-white transition-colors">
                                        <td class="py-3 px-4 text-sm font-semibold text-gray-800">#<?php echo e($transaction->id); ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-600"><?php echo e($transaction->booking->user->name ?? 'N/A'); ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-600"><?php echo e(Str::limit($transaction->booking->event->title ?? 'N/A', 30)); ?></td>
                                        <td class="py-3 px-4 text-sm font-bold text-green-600">$<?php echo e(number_format($transaction->amount, 2)); ?></td>
                                        <td class="py-3 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                <?php echo e(ucfirst($transaction->status)); ?>

                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-500"><?php echo e($transaction->created_at->format('M d, Y')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-500">No transactions yet</td>
                                    </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div id="notifications-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Admin Notifications & Alerts
                            </h3>
                            <p class="text-gray-600">Stay updated with important system events</p>
                        </div>
                        <button onclick="location.reload()" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                    </div>

                    <?php
                        $todayBookings = \App\Models\Booking::whereDate('created_at', today())->count();
                        $pendingBookings = \App\Models\Payment::where('status', 'pending')->count();
                        $newUsers = \App\Models\User::whereDate('created_at', today())->count();
                        $pendingRequests = \App\Models\EventRequest::where('status', 'pending')->count();
                        $upcomingEvents = \App\Models\Event::where('date', '>', now())->where('date', '<', now()->addWeek())->count();
                    ?>

                    <!-- Alert Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-xl p-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-black text-blue-600"><?php echo e($todayBookings); ?></p>
                                    <p class="text-sm text-gray-600 font-semibold">Bookings Today</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-white border border-orange-200 rounded-xl p-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-orange-100 rounded-lg">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-black text-orange-600"><?php echo e($pendingBookings); ?></p>
                                    <p class="text-sm text-gray-600 font-semibold">Pending Payments</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-white border border-purple-200 rounded-xl p-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-black text-purple-600"><?php echo e($newUsers); ?></p>
                                    <p class="text-sm text-gray-600 font-semibold">New Users Today</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Feed -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-black text-gray-800 mb-4">Recent Activity</h4>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingRequests > 0): ?>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-bold text-yellow-800"><?php echo e($pendingRequests); ?> Pending Event Requests</p>
                                    <p class="text-sm text-yellow-700 mt-1">Review and approve pending event requests</p>
                                    <a href="#requests" data-tab="requests" class="text-yellow-600 font-semibold text-sm hover:underline mt-2 inline-block">View Requests →</a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingEvents > 0): ?>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-bold text-blue-800"><?php echo e($upcomingEvents); ?> Events This Week</p>
                                    <p class="text-sm text-blue-700 mt-1">You have upcoming events in the next 7 days</p>
                                    <a href="#events" data-tab="events" class="text-blue-600 font-semibold text-sm hover:underline mt-2 inline-block">View Events →</a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php
                            $recentActivity = [
                                ['type' => 'booking', 'count' => $todayBookings, 'text' => 'bookings received today'],
                                ['type' => 'user', 'count' => $newUsers, 'text' => 'new users registered'],
                                ['type' => 'payment', 'count' => $pendingBookings, 'text' => 'payments pending'],
                            ];
                        ?>

                        <?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity['count'] > 0): ?>
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl flex items-center gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <p class="text-gray-700"><span class="font-bold text-gray-900"><?php echo e($activity['count']); ?></span> <?php echo e($activity['text']); ?></p>
                            <span class="ml-auto text-xs text-gray-500"><?php echo e(now()->format('M d, Y')); ?></span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($todayBookings == 0 && $newUsers == 0 && $pendingBookings == 0 && $pendingRequests == 0): ?>
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <p class="text-gray-500 font-semibold">No new notifications</p>
                            <p class="text-sm text-gray-400 mt-1">All caught up!</p>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div id="emails-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Bulk Email Manager
                            </h3>
                            <p class="text-gray-600">Send announcements and updates to your users</p>
                        </div>
                    </div>

                    <!-- Email Form -->
                    <form action="<?php echo e(route('admin.send-bulk-email')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Recipient Selection -->
                        <div class="bg-blue-50 rounded-xl p-6">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Send To</label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="recipient_type" value="all" checked class="w-4 h-4 text-blue-600">
                                    <span class="text-gray-700 font-semibold">All Users (<?php echo e(\App\Models\User::where('role', 'user')->count()); ?> users)</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="recipient_type" value="recent_bookings" class="w-4 h-4 text-blue-600">
                                    <span class="text-gray-700 font-semibold">Users with Recent Bookings</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="recipient_type" value="upcoming_events" class="w-4 h-4 text-blue-600">
                                    <span class="text-gray-700 font-semibold">Users with Upcoming Events</span>
                                </label>
                            </div>
                        </div>

                        <!-- Email Subject -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Subject *</label>
                            <input type="text" name="subject" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Enter email subject...">
                        </div>

                        <!-- Email Message -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Message *</label>
                            <textarea name="message" required rows="8"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                      placeholder="Compose your message..."></textarea>
                            <p class="text-xs text-gray-500 mt-2">Tip: Keep your message clear and concise. Include a call-to-action if needed.</p>
                        </div>

                        <!-- Quick Templates -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <p class="text-sm font-bold text-gray-700 mb-3">Quick Templates</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <button type="button" onclick="useTemplate('new_event')" 
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 text-sm font-semibold text-gray-700 transition-colors">
                                    📅 New Event Announcement
                                </button>
                                <button type="button" onclick="useTemplate('maintenance')"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 text-sm font-semibold text-gray-700 transition-colors">
                                    🔧 System Maintenance
                                </button>
                                <button type="button" onclick="useTemplate('reminder')"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 text-sm font-semibold text-gray-700 transition-colors">
                                    ⏰ Event Reminder
                                </button>
                            </div>
                        </div>

                        <!-- Send Button -->
                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Send Email
                            </button>
                            <p class="text-sm text-gray-500">Emails will be sent immediately</p>
                        </div>
                    </form>

                    <script>
                        function useTemplate(type) {
                            const templates = {
                                new_event: {
                                    subject: '🎉 New Event Alert: Check Out Our Latest Event!',
                                    message: 'Dear Valued User,\n\nWe\'re excited to announce a new event! Don\'t miss out on this amazing opportunity.\n\nVisit our platform to view details and book your tickets today.\n\nBest regards,\nEvent Management Team'
                                },
                                maintenance: {
                                    subject: '⚠️ Scheduled System Maintenance Notice',
                                    message: 'Dear User,\n\nWe\'ll be performing scheduled maintenance to improve our services. The platform may be temporarily unavailable.\n\nMaintenance Window: [Date and Time]\n\nWe apologize for any inconvenience.\n\nThank you for your understanding.'
                                },
                                reminder: {
                                    subject: '⏰ Reminder: Your Event is Coming Up!',
                                    message: 'Hi there!\n\nThis is a friendly reminder about your upcoming event. Don\'t forget to bring your ticket!\n\nWe look forward to seeing you there.\n\nBest regards,\nEvent Management Team'
                                }
                            };

                            if (templates[type]) {
                                document.querySelector('input[name="subject"]').value = templates[type].subject;
                                document.querySelector('textarea[name="message"]').value = templates[type].message;
                            }
                        }
                    </script>
                </div>
            </div>

            
            <div id="checkin-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Event Check-in Management
                            </h3>
                            <p class="text-gray-600">Scan QR codes and manage event attendance</p>
                        </div>
                        <a href="<?php echo e(route('attendance.scanner')); ?>" 
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            Open QR Scanner
                        </a>
                    </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <?php
                        $totalAttendances = \App\Models\Attendance::count();
                        $checkedIn = \App\Models\Attendance::where('status', 'checked_in')->count();
                        $pending = \App\Models\Attendance::where('status', 'pending')->count();
                        $checkInRate = $totalAttendances > 0 ? round(($checkedIn / $totalAttendances) * 100, 1) : 0;
                    ?>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Total Tickets</p>
                                <p class="text-3xl font-bold text-blue-600"><?php echo e($totalAttendances); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Checked In</p>
                                <p class="text-3xl font-bold text-green-600"><?php echo e($checkedIn); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 border border-yellow-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Pending</p>
                                <p class="text-3xl font-bold text-yellow-600"><?php echo e($pending); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Check-in Rate</p>
                                <p class="text-3xl font-bold text-purple-600"><?php echo e($checkInRate); ?>%</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Check-ins -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Recent Check-ins</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendee</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Checked In</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Checked By</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php
                                    $recentCheckIns = \App\Models\Attendance::with(['user', 'event', 'checker'])
                                        ->where('status', 'checked_in')
                                        ->latest('checked_in_at')
                                        ->take(10)
                                        ->get();
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentCheckIns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                                <?php echo e(substr($attendance->user->name, 0, 1)); ?>

                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-900"><?php echo e($attendance->user->name); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo e($attendance->user->email); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900"><?php echo e($attendance->event->title); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($attendance->event->date->format('M d, Y')); ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Checked In
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo e($attendance->checked_in_at->format('M d, Y g:i A')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo e($attendance->checker ? $attendance->checker->name : 'System'); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No check-ins yet
                                    </td>
                                </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>

            
            <div id="feedback-tab" class="tab-content hidden animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-sm p-8 border border-blue-50">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-black mb-2">
                                Feedback & Ratings Management
                            </h3>
                            <p class="text-gray-600">Moderate and manage user feedback for events</p>
                        </div>
                    </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <?php
                        $totalFeedback = \App\Models\Feedback::count();
                        $approvedFeedback = \App\Models\Feedback::where('is_approved', true)->count();
                        $pendingFeedback = \App\Models\Feedback::where('is_approved', false)->count();
                        $averageRating = \App\Models\Feedback::where('is_approved', true)->avg('rating') ?? 0;
                    ?>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Total Feedback</p>
                                <p class="text-3xl font-bold text-blue-600"><?php echo e($totalFeedback); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Approved</p>
                                <p class="text-3xl font-bold text-green-600"><?php echo e($approvedFeedback); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 border border-yellow-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Pending Review</p>
                                <p class="text-3xl font-bold text-yellow-600"><?php echo e($pendingFeedback); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 mb-1">Average Rating</p>
                                <p class="text-3xl font-bold text-purple-600"><?php echo e(number_format($averageRating, 1)); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback List -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Recent Feedback</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php
                            $recentFeedback = \App\Models\Feedback::with(['user', 'event'])
                                ->latest()
                                ->take(10)
                                ->get();
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentFeedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                        <?php echo e(substr($feedback->user->name, 0, 1)); ?>

                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900"><?php echo e($feedback->user->name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($feedback->event->title); ?></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <!-- Star Rating -->
                                    <div class="flex">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= $feedback->rating): ?>
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->is_approved): ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->comment): ?>
                            <p class="text-gray-700 mb-3"><?php echo e($feedback->comment); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500"><?php echo e($feedback->created_at->diffForHumans()); ?></p>
                                <div class="flex gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$feedback->is_approved): ?>
                                    <form action="<?php echo e(route('feedback.approve', $feedback->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="px-3 py-1 text-xs bg-green-500 text-white rounded-lg hover:bg-green-600">
                                            Approve
                                        </button>
                                    </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <form action="<?php echo e(route('feedback.destroy', $feedback->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="px-3 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600" 
                                                onclick="return confirm('Are you sure you want to delete this feedback?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-8 text-center text-gray-500">
                            No feedback yet
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Wait for full page load including Alpine.js
    window.addEventListener('load', function() {
        console.log('Admin Dashboard: Initializing tab functionality');
        
        // Tab switching logic
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        console.log('Found', tabLinks.length, 'tab links');
        console.log('Found', tabContents.length, 'tab contents');

        function switchTab(tabName) {
            console.log('Switching to tab:', tabName);
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tabs
            tabLinks.forEach(link => {
                link.classList.remove('bg-blue-50', 'border-blue-400', 'shadow-md');
                link.classList.add('bg-white', 'border-gray-200');
            });

            // Show selected tab content
            const selectedTab = document.getElementById(tabName + '-tab');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
                console.log('Showing tab:', tabName + '-tab');
            } else {
                console.error('Tab not found:', tabName + '-tab');
            }

            // Add active state to selected tab link
            const selectedLink = document.querySelector(`.tab-link[data-tab="${tabName}"]`);
            if (selectedLink) {
                selectedLink.classList.remove('bg-white', 'border-gray-200');
                selectedLink.classList.add('bg-blue-50', 'border-blue-400', 'shadow-md');
            }

            // Update URL hash
            history.replaceState(null, null, '#' + tabName);
        }

        // Add click event to each tab link
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const tabName = this.dataset.tab;
                console.log('Tab clicked:', tabName);
                switchTab(tabName);
            });
        });

        // Initialize: Show first tab or tab from URL hash
        const hashTab = window.location.hash.replace('#', '');
        const initialTab = hashTab || 'events';
        console.log('Initial tab:', initialTab);
        switchTab(initialTab);

        // Approve modal logic
        const approveModal = document.getElementById('approve-modal-dashboard');
        const approveModalTitle = document.getElementById('approve-modal-title-dashboard');
        const approveForm = document.getElementById('approve-form-dashboard');
        
        document.querySelectorAll('.open-approve-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const title = this.getAttribute('data-title') || 'this request';
                
                if (approveForm) approveForm.setAttribute('action', action);
                if (approveModalTitle) approveModalTitle.textContent = 'Approve "' + title + '"? This will create an event based on the request.';
                
                if (approveModal) {
                    approveModal.classList.remove('hidden');
                    approveModal.classList.add('flex');
                }
            });
        });

        document.getElementById('approve-modal-cancel-dashboard')?.addEventListener('click', function() {
            if (approveModal) {
                approveModal.classList.add('hidden');
                approveModal.classList.remove('flex');
            }
        });

        document.getElementById('approve-modal-confirm-dashboard')?.addEventListener('click', function() {
            if (approveForm) approveForm.submit();
        });

        // Delete modal logic
        const deleteModal = document.getElementById('delete-modal-dashboard');
        const deleteModalTitle = document.getElementById('delete-modal-title-dashboard');
        const deleteForm = document.getElementById('delete-form-dashboard');
        
        document.querySelectorAll('.open-delete-modal-dashboard').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const title = this.getAttribute('data-title') || 'this request';
                
                if (deleteForm) deleteForm.setAttribute('action', action);
                if (deleteModalTitle) deleteModalTitle.textContent = 'Delete "' + title + '"? This action cannot be undone.';
                
                if (deleteModal) {
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                }
            });
        });

        document.getElementById('delete-modal-cancel-dashboard')?.addEventListener('click', function() {
            if (deleteModal) {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            }
        });

        document.getElementById('delete-modal-confirm-dashboard')?.addEventListener('click', function() {
            if (deleteForm) deleteForm.submit();
        });

        // Reject modal logic
        const rejectModal = document.getElementById('reject-modal-dashboard');
        const rejectModalTitle = document.getElementById('reject-modal-title-dashboard');
        const rejectForm = document.getElementById('reject-form-dashboard');
        const rejectReasonTextarea = document.getElementById('rejection-reason-textarea');
        const rejectReasonInput = document.getElementById('rejection-reason-input');
        
        document.querySelectorAll('.open-reject-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const title = this.getAttribute('data-title') || 'this request';
                
                if (rejectForm) rejectForm.setAttribute('action', action);
                if (rejectModalTitle) rejectModalTitle.textContent = 'You are about to reject "' + title + '". Please provide a reason.';
                if (rejectReasonTextarea) rejectReasonTextarea.value = '';
                
                if (rejectModal) {
                    rejectModal.classList.remove('hidden');
                    rejectModal.classList.add('flex');
                }
            });
        });

        document.getElementById('reject-modal-cancel-dashboard')?.addEventListener('click', function() {
            if (rejectModal) {
                rejectModal.classList.add('hidden');
                rejectModal.classList.remove('flex');
            }
        });

        document.getElementById('reject-modal-confirm-dashboard')?.addEventListener('click', function() {
            const reason = rejectReasonTextarea ? rejectReasonTextarea.value.trim() : '';
            
            if (!reason) {
                alert('Please provide a reason for rejection.');
                return;
            }
            
            if (rejectReasonInput) rejectReasonInput.value = reason;
            if (rejectForm) rejectForm.submit();
        });
    });
</script>


<form id="approve-form-dashboard" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
</form>
<div id="approve-modal-dashboard" class="hidden fixed inset-0 z-50 items-center justify-center">
    <div class="fixed inset-0 bg-black/50"></div>
    <div class="bg-white rounded-lg p-6 z-10 max-w-md w-full">
        <h3 class="text-lg font-bold text-slate-900 mb-2">Approve Request</h3>
        <p id="approve-modal-title-dashboard" class="text-sm text-slate-700 mb-4"></p>
        <div class="flex justify-end gap-3">
            <button id="approve-modal-cancel-dashboard" type="button" class="px-4 py-2 rounded-lg bg-gray-100 text-slate-700">Cancel</button>
            <button id="approve-modal-confirm-dashboard" type="button" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Confirm Approve</button>
        </div>
    </div>
</div>



<form id="reject-form-dashboard" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="rejection_reason" id="rejection-reason-input">
</form>

<div id="reject-modal-dashboard" class="hidden fixed inset-0 z-50 items-center justify-center">
    <div class="fixed inset-0 bg-black/50"></div>
    <div class="bg-white rounded-xl shadow-2xl p-6 z-10 max-w-lg w-full mx-4">
        <div class="flex items-start gap-3 mb-4">
            <div class="p-2 bg-red-100 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Reject Event Request</h3>
                <p id="reject-modal-title-dashboard" class="text-sm text-gray-600"></p>
            </div>
        </div>
        
        <div class="mb-6">
            <label for="rejection-reason-textarea" class="block text-sm font-semibold text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
            <textarea id="rejection-reason-textarea" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Please provide a detailed reason for rejecting this event request..."></textarea>
            <p class="text-xs text-gray-500 mt-1">This reason will be sent to the user.</p>
        </div>
        
        <div class="flex justify-end gap-3">
            <button id="reject-modal-cancel-dashboard" type="button" class="px-5 py-2.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition-colors">Cancel</button>
            <button id="reject-modal-confirm-dashboard" type="button" class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors">Reject Request</button>
        </div>
    </div>
</div>

<form id="delete-form-dashboard" method="POST" style="display:none;"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?></form>

<div id="delete-modal-dashboard" class="hidden fixed inset-0 z-50 items-center justify-center">
    <div class="fixed inset-0 bg-black/50"></div>
    <div class="bg-white rounded-lg p-6 z-10 max-w-md w-full">
        <h3 class="text-lg font-bold text-red-700 mb-2">Delete Request</h3>
        <p id="delete-modal-title-dashboard" class="text-sm text-slate-700 mb-4"></p>
        <div class="flex justify-end gap-3">
            <button id="delete-modal-cancel-dashboard" type="button" class="px-4 py-2 rounded-lg bg-gray-100 text-slate-700">Cancel</button>
            <button id="delete-modal-confirm-dashboard" type="button" class="px-4 py-2 rounded-lg bg-red-600 text-white">Confirm Delete</button>
        </div>
    </div>
</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/admin-dashboard.blade.php ENDPATH**/ ?>