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
        <div class="bg-gradient-to-r from-blue-50 to-white rounded-2xl p-4 mb-6 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-900">
                        Event Details
                    </h2>
                    <div class="h-1 w-20 bg-blue-500 rounded-full mt-1"></div>
                    <p class="text-gray-600 mt-1 text-sm">Complete information about this event</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section with Featured Image -->
            <?php
                $featuredImage = $event->images->first();
            ?>
            <div class="relative h-96 overflow-hidden rounded-3xl shadow-2xl mb-8">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredImage): ?>
                    <img src="<?php echo e(Storage::url($featuredImage->file_path)); ?>" 
                         alt="<?php echo e($event->name); ?>" 
                         class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <?php else: ?>
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <!-- Event Title Overlay -->
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <div class="max-w-4xl">
                        <div class="flex items-center gap-3 mb-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->category): ?>
                                <span class="px-4 py-2 bg-blue-500 text-white font-bold rounded-full text-sm uppercase">
                                    <?php echo e($event->category); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->price == 0): ?>
                                <span class="px-4 py-2 bg-green-500 text-white font-bold rounded-full text-sm">
                                    🎉 FREE
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <h1 class="text-5xl font-black text-white mb-4 drop-shadow-lg">
                            <?php echo e($event->name); ?>

                        </h1>
                        <div class="flex items-center gap-6 text-white/90">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold"><?php echo e($event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y • g:i A') : 'Date TBA'); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold"><?php echo e($event->venue ? $event->venue->name : $event->location); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Bar (Sticky) -->
            <div class="sticky top-20 z-40 bg-white/95 backdrop-blur-lg shadow-lg rounded-2xl p-4 mb-8 border border-gray-200" x-data="{ 
                shareEvent() { 
                    if (navigator.share) {
                        navigator.share({
                            title: '<?php echo e($event->name); ?>',
                            text: 'Check out this event: <?php echo e($event->name); ?>',
                            url: window.location.href
                        });
                    } else {
                        navigator.clipboard.writeText(window.location.href);
                        alert('Event link copied to clipboard!');
                    }
                } 
            }">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->capacity): ?>
                            <?php
                                $bookingsCount = $event->bookings_count ?? 0;
                                $spotsLeft = $event->capacity - $bookingsCount;
                                $percentFilled = $event->capacity > 0 ? ($bookingsCount / $event->capacity) * 100 : 0;
                            ?>
                            <!-- Attendee Count -->
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-700">
                                    <span class="text-blue-600"><?php echo e($bookingsCount); ?></span> attending
                                </span>
                            </div>

                            <!-- Spots Remaining -->
                            <div class="h-6 w-px bg-gray-300"></div>
                            <div class="flex items-center gap-2">
                                <div class="relative w-8 h-8">
                                    <svg class="transform -rotate-90 w-8 h-8">
                                        <circle cx="16" cy="16" r="14" stroke="#E5E7EB" stroke-width="4" fill="none"/>
                                        <circle 
                                            cx="16" cy="16" r="14" 
                                            stroke="<?php echo e($percentFilled > 80 ? '#EF4444' : '#3B82F6'); ?>" 
                                            stroke-width="4" 
                                            fill="none"
                                            stroke-dasharray="<?php echo e(2 * 3.14159 * 14); ?>"
                                            stroke-dashoffset="<?php echo e(2 * 3.14159 * 14 * (1 - $percentFilled / 100)); ?>"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                    <span class="absolute inset-0 flex items-center justify-center text-xs font-bold <?php echo e($percentFilled > 80 ? 'text-red-600' : 'text-blue-600'); ?>">
                                        <?php echo e($spotsLeft); ?>

                                    </span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">spots left</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3">
                        <!-- Share Button -->
                        <button 
                            @click="shareEvent()"
                            class="px-4 py-2 border-2 border-blue-500 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-200 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share
                        </button>

                        <?php if($event->price !== null): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->capacity && ($event->bookings_count ?? 0) >= $event->capacity): ?>
                                <div class="px-8 py-3 bg-gray-400 text-white font-bold rounded-xl cursor-not-allowed">
                                    ❌ Sold Out
                                </div>
                            <?php else: ?>
                                <a href="<?php echo e(route('bookings.create')); ?>?event=<?php echo e($event->id); ?>" 
                                   class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                    🎫 Book Now
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->price > 0): ?>
                                        <span class="ml-2">$<?php echo e(number_format($event->price, 2)); ?></span>
                                    <?php else: ?>
                                        <span class="ml-2 text-yellow-300">FREE</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="relative bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-2xl shadow-xl overflow-hidden">
                <div class="relative p-6">
                    <!-- Event Details -->
                    <div class="mb-8">
                        
                        <!-- Event Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Description -->
                            <div class="lg:col-span-3 bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                                            <circle cx="12" cy="12" r="2" fill="white" opacity="0.8"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-lg">Description</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl">
                                    <p class="text-gray-700 leading-relaxed text-sm"><?php echo e($event->description ?: 'No description provided.'); ?></p>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="bg-white rounded-2xl p-5 border border-blue-200 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <rect x="3" y="5" width="18" height="16" rx="2" stroke-linecap="round"/>
                                            <path d="M3 9h18M7 3v4M17 3v4" stroke-linecap="round"/>
                                            <circle cx="12" cy="15" r="3.5"/>
                                            <path d="M12 13.5v2l1.5 1" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Date & Time</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 text-sm font-bold"><?php echo e($event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y') : 'N/A'); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->date): ?>
                                        <p class="text-blue-600 text-xs font-semibold mt-1"><?php echo e(\Carbon\Carbon::parse($event->date)->format('g:i A')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                            <circle cx="12" cy="9" r="3" fill="white" opacity="0.9"/>
                                            <path d="M12 20c-1 0-2-.5-2-1s1-1 2-1 2 .5 2 1-1 1-2 1z" opacity="0.6"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Location</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm"><?php echo e($event->location); ?></p>
                                </div>
                            </div>

                            <!-- Venue -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 21h18" stroke-linecap="round"/>
                                            <path d="M4 21V8l8-5 8 5v13" stroke-linecap="round" stroke-linejoin="round"/>
                                            <rect x="9" y="12" width="6" height="5" fill="currentColor" opacity="0.5"/>
                                            <path d="M7 11h2M15 11h2M7 15h2M15 15h2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Venue</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm"><?php echo e($event->venue ? $event->venue->name : 'N/A'); ?></p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <path d="M3 12h4l3-9 4 18 3-9h4" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Status</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl flex justify-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strtolower($event->status) == 'active'): ?>
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-black rounded-xl bg-blue-500 text-white shadow-md">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-black rounded-xl bg-gray-400 text-white shadow-md">
                                            <?php echo e(ucfirst($event->status)); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="bg-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="8" r="4" fill="currentColor" opacity="0.8"/>
                                            <path d="M4 20c0-4 3.5-7 8-7s8 3 8 7" stroke-linecap="round"/>
                                            <path d="M16 6l2-2M8 6L6 4" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-black text-gray-900 text-base">Created By</h4>
                                </div>
                                <div class="bg-blue-50 px-4 py-3 rounded-xl text-center">
                                    <p class="text-gray-900 font-bold text-sm"><?php echo e($event->user ? $event->user->name : 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="my-6">
                        <div class="h-px bg-gradient-to-r from-transparent via-blue-300 to-transparent"></div>
                    </div>

                    <!-- Enhanced Image Gallery with Lightbox -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->images && $event->images->count() > 0): ?>
                        <div class="mb-8" x-data="{ 
                            lightbox: false, 
                            currentImage: 0,
                            images: <?php echo e($event->images->pluck('file_path')->toJson()); ?>,
                            captions: <?php echo e($event->images->pluck('caption')->toJson()); ?>

                        }">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                Event Gallery
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $event->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div 
                                        @click="lightbox = true; currentImage = <?php echo e($index); ?>"
                                        class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300"
                                    >
                                        <img 
                                            src="<?php echo e(Storage::url($image->file_path)); ?>" 
                                            alt="<?php echo e($image->caption); ?>" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        />
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image->caption): ?>
                                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent">
                                                <p class="text-white text-xs font-semibold truncate"><?php echo e($image->caption); ?></p>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Lightbox Modal -->
                            <div 
                                x-show="lightbox" 
                                x-cloak
                                @click.self="lightbox = false"
                                @keydown.escape.window="lightbox = false"
                                class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
                                style="display: none;"
                            >
                                <button @click="lightbox = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <button 
                                    @click="currentImage = currentImage > 0 ? currentImage - 1 : images.length - 1" 
                                    class="absolute left-4 text-white hover:text-gray-300 z-50"
                                >
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <div class="max-w-6xl mx-auto">
                                    <img 
                                        :src="'/storage/' + images[currentImage]" 
                                        :alt="captions[currentImage]"
                                        class="max-h-[85vh] max-w-full object-contain mx-auto"
                                    />
                                    <p 
                                        x-show="captions[currentImage]"
                                        x-text="captions[currentImage]"
                                        class="text-white text-center mt-4 text-lg"
                                    ></p>
                                </div>
                                
                                <button 
                                    @click="currentImage = currentImage < images.length - 1 ? currentImage + 1 : 0" 
                                    class="absolute right-4 text-white hover:text-gray-300 z-50"
                                >
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white font-bold bg-black/50 px-4 py-2 rounded-lg">
                                    <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Divider -->
                    <div class="my-6">
                        <div class="h-px bg-gradient-to-r from-transparent via-blue-300 to-transparent"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <form method="POST" action="<?php echo e(route('favorites.toggle', $event)); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="group relative <?php echo e(auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-blue-50 hover:bg-blue-100 text-blue-600'); ?>

                                               active:scale-95 transition-all duration-300
                                               px-5 py-2.5 rounded-xl font-bold text-sm
                                               shadow-md hover:shadow-lg
                                               flex items-center gap-2">
                                    <svg class="w-4 h-4 <?php echo e(auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'group-hover:scale-110' : 'group-hover:animate-pulse'); ?> transition-transform duration-300" fill="<?php echo e(auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span><?php echo e(auth()->user()->favoritedEvents()->where('event_id', $event->id)->exists() ? 'Remove from Favorites' : 'Add to Favorites'); ?></span>
                                </button>
                            </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>"
                           class="group relative bg-blue-50 hover:bg-blue-100
                                  active:scale-95 transition-all duration-300
                                  text-gray-900 px-5 py-2.5 rounded-xl font-bold text-sm
                                  shadow-md hover:shadow-lg
                                  flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
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
<?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/events/show.blade.php ENDPATH**/ ?>