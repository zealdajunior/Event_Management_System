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
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Events Management
                    </h2>
                    <div class="h-1 w-24 bg-white/80 rounded-full mt-2"></div>
                    <p class="text-white/90 mt-2">Manage and organize all your events</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-300 shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-500 rounded-xl shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-green-800">Success!</h3>
                            <p class="text-green-700"><?php echo e(session('status')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                        <div>
                            <h3 class="text-3xl font-black text-gray-800 mb-2">
                                All Events
                            </h3>
                            <p class="text-gray-600 text-lg">Comprehensive list of all events in the system</p>
                        </div>
                        <a href="<?php echo e(route('events.create')); ?>"
                           class="group relative bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                                  active:scale-95 transition-all duration-300
                                  text-white px-8 py-4 rounded-xl font-bold shadow-lg
                                  hover:shadow-xl flex items-center gap-3">
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Create New Event</span>
                        </a>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($events->count() > 0): ?>
                        <!-- Modern Card Grid Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $featuredImage = $event->images->first();
                                    $bookingsCount = $event->bookings_count ?? 0;
                                ?>
                                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden border border-gray-200">
                                    <!-- Event Image -->
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-500 to-blue-700">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredImage): ?>
                                            <img src="<?php echo e(Storage::url($featuredImage->file_path)); ?>" 
                                                 alt="<?php echo e($event->name); ?>" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                        <?php else: ?>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <!-- Category Badge -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->category): ?>
                                            <div class="absolute top-3 left-3">
                                                <span class="px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full shadow-lg backdrop-blur-sm">
                                                    <?php echo e(strtoupper($event->category)); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <!-- Status Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full shadow-lg backdrop-blur-sm <?php echo e($event->status == 'active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'); ?>">
                                                <?php echo e(ucfirst($event->status)); ?>

                                            </span>
                                        </div>
                                        
                                        <!-- Price Tag -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->price !== null): ?>
                                            <div class="absolute bottom-3 right-3">
                                                <span class="px-3 py-1 <?php echo e($event->price == 0 ? 'bg-green-500' : 'bg-blue-500'); ?> text-white text-sm font-bold rounded-full shadow-lg">
                                                    <?php echo e($event->price == 0 ? 'FREE' : '$' . number_format($event->price, 2)); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    
                                    <!-- Event Details -->
                                    <div class="p-6">
                                        <h3 class="text-xl font-black text-gray-900 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                                            <?php echo e($event->name); ?>

                                        </h3>
                                        
                                        <div class="space-y-2 mb-4">
                                            <!-- Date -->
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="font-semibold"><?php echo e($event->date ? \Carbon\Carbon::parse($event->date)->format('M j, Y • g:i A') : 'Date TBA'); ?></span>
                                            </div>
                                            
                                            <!-- Location -->
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="truncate"><?php echo e($event->venue ? $event->venue->name : ($event->location ?? 'Location TBA')); ?></span>
                                            </div>
                                            
                                            <!-- Capacity -->
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->capacity): ?>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                    </svg>
                                                    <span><strong class="text-blue-600"><?php echo e($bookingsCount); ?></strong> / <?php echo e($event->capacity); ?> attending</span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex items-center gap-2 pt-4 border-t border-gray-200">
                                            <a href="<?php echo e(route('events.show', $event)); ?>"
                                               class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-bold rounded-lg transition-all duration-300 hover:shadow-lg text-center">
                                                View Details
                                            </a>
                                            <a href="<?php echo e(route('events.edit', $event)); ?>"
                                               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg transition-all duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('events.destroy', $event)); ?>" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold rounded-lg transition-all duration-300"
                                                        onclick="return confirm('Are you sure you want to delete this event?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-16">
                            <div class="p-6 bg-blue-100 rounded-3xl inline-block mb-6 border-2 border-blue-300">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-800 mb-2">No Events Found</h4>
                            <p class="text-gray-600 text-lg mb-6">Start creating amazing events to see them here</p>
                            <a href="<?php echo e(route('events.create')); ?>"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                                      text-white px-8 py-4 rounded-xl font-bold shadow-lg
                                      hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95">
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
<?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/events/index.blade.php ENDPATH**/ ?>