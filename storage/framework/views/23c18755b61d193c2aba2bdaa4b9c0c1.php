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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Request New Event
                    </h2>
                    <div class="h-1 w-24 bg-white/80 rounded-full mt-2"></div>
                    <p class="text-white/90 mt-2">Submit your event details for admin approval - same powerful form as admins use!</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <!-- Approval Notice Banner -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 p-6 rounded-r-2xl shadow-lg">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-amber-900 mb-2">📋 Event Approval Process</h3>
                    <p class="text-amber-800 text-sm mb-3">Your event will be reviewed by our admin team before going live. This ensures quality and safety for all attendees.</p>
                    <div class="bg-white rounded-xl p-4 border border-amber-200">
                        <p class="text-sm font-semibold text-gray-900 mb-2">What happens next:</p>
                        <ol class="text-sm text-gray-700 space-y-2 list-decimal list-inside">
                            <li>You submit this comprehensive event form</li>
                            <li>Admin reviews your event details (usually within 24-48 hours)</li>
                            <li>If approved, your event goes live and appears in search</li>
                            <li>You'll receive an email notification about the approval status</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <!-- Progress Indicator -->
                    <div x-data="{ currentStep: 1, totalSteps: 6 }" class="mb-8">
                        <!-- Compact Horizontal Step Indicators -->
                        <div class="flex items-center justify-between gap-2">
                            <template x-for="step in totalSteps" :key="step">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center">
                                        <div 
                                            :class="step <= currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
                                            class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all duration-300"
                                        >
                                            <span x-text="step"></span>
                                        </div>
                                        <span 
                                            :class="step === currentStep ? 'text-blue-600 font-bold' : 'text-gray-500'"
                                            class="text-xs ml-2 transition-colors duration-300 hidden sm:inline"
                                            x-text="['Basic', 'Details', 'Date', 'Location', 'Media', 'Review'][step - 1]"
                                        ></span>
                                    </div>
                                    <!-- Connector Line -->
                                    <div 
                                        x-show="step < totalSteps"
                                        :class="step < currentStep ? 'bg-blue-600' : 'bg-gray-300'"
                                        class="hidden md:block h-0.5 w-8 transition-all duration-300"
                                    ></div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Progress Text -->
                        <p class="text-center text-sm text-gray-600 mt-3 font-semibold">
                            Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>
                            (<span x-text="Math.round((currentStep / totalSteps) * 100)"></span>% complete)
                        </p>
                    </div>

                    <form method="POST" action="<?php echo e(route('event-requests.store')); ?>" enctype="multipart/form-data" x-data="{
                        eventName: '<?php echo e(old('name')); ?>',
                        isValidName: <?php echo e(old('name') ? 'true' : 'false'); ?>,
                        capacity: <?php echo e(old('capacity', 100)); ?>,
                        price: <?php echo e(old('price', 0)); ?>,
                        expectedAttendance: <?php echo e(old('capacity', 100) * 0.7); ?>,
                        startDate: '<?php echo e(old('date')); ?>',
                        endDate: '<?php echo e(old('end_date')); ?>',
                        validateDates() {
                            if(this.startDate && this.endDate) {
                                return new Date(this.endDate) > new Date(this.startDate);
                            }
                            return true;
                        },
                        calculateRevenue() {
                            return (this.price * this.expectedAttendance).toFixed(2);
                        }
                    }">
                        <?php echo csrf_field(); ?>

                        <!-- Basic Information -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Basic Information</h3>
                                    <p class="text-sm text-gray-600">Start with the fundamentals of your event</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div x-data="{ eventName: '<?php echo e(old('name')); ?>', isValidName: <?php echo e(old('name') && strlen(old('name')) >= 3 ? 'true' : 'false'); ?> }">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'name','value' => __('Event Name *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Name *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <input 
                                            id="name" 
                                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                            :class="eventName.length > 0 && !isValidName ? 'border-red-500' : (isValidName ? 'border-green-500' : '')"
                                            type="text" 
                                            name="name" 
                                            :value="eventName"
                                            x-model="eventName"
                                            @input="isValidName = eventName.length >= 3"
                                            required 
                                            autofocus 
                                            autocomplete="name" 
                                            placeholder="e.g., Annual Tech Conference 2026"
                                        />
                                        <p class="text-xs text-gray-500 mt-1">Choose a clear, descriptive name that tells people what your event is about</p>
                                        <p x-show="eventName.length > 0 && !isValidName" class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Event name must be at least 3 characters
                                        </p>
                                        <p x-show="isValidName" class="text-green-500 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Looks good!
                                        </p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('name'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'category_id','value' => __('Event Category *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'category_id','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Category *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <select id="category_id" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" name="category_id" required>
                                            <option value="">Select a category</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" 
                                                        <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>

                                                        style="color: <?php echo e($category->color); ?>">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->icon): ?>
                                                        <i class="fas fa-<?php echo e($category->icon); ?>"></i> 
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">This helps attendees find your event when searching</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('category_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('category_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>

                                <!-- Event Summary (NEW MVP FIELD) -->
                                <div class="mt-6">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'summary','value' => __('Event Summary *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'summary','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Summary *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <textarea 
                                        id="summary" 
                                        name="summary" 
                                        rows="2" 
                                        maxlength="200"
                                        class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full resize-none" 
                                        placeholder="A brief 1-2 line summary of your event (max 200 characters)"
                                        x-data="{ count: <?php echo e(strlen(old('summary', ''))); ?> }"
                                        @input="count = $el.value.length"
                                        required
                                    ><?php echo e(old('summary')); ?></textarea>
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="text-xs text-gray-500">📝 Quick overview displayed in event listings</p>
                                        <p class="text-xs" :class="count > 180 ? 'text-red-600 font-bold' : 'text-gray-500'">
                                            <span x-text="count"></span>/200
                                        </p>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('summary'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('summary')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Event Description</h3>
                                    <p class="text-sm text-gray-600">Help attendees understand what to expect from your event</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'description','value' => __('Detailed Description *'),'class' => 'text-gray-700 font-semibold mb-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'description','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Detailed Description *')),'class' => 'text-gray-700 font-semibold mb-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <p class="text-xs text-gray-600 mb-3">Use the editor below to format your event description. You can add headings, lists, bold text, and more.</p>
                                
                                <input id="description" type="hidden" name="description" value="<?php echo e(old('description')); ?>" required>
                                <trix-editor 
                                    input="description" 
                                    class="trix-content border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg min-h-[300px] bg-white"
                                    placeholder="Describe your event in detail. Include:
• What will happen at the event
• Who should attend
• What attendees will learn or experience
• Any special guests or speakers
• Schedule highlights
• What to bring or prepare
• Dress code (if applicable)
• Parking and accessibility information"></trix-editor>
                                
                                <p class="text-xs text-gray-500 mt-2">A comprehensive description helps attendees decide if this event is right for them</p>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('description'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('description')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <style>
                            /* Custom Trix Editor Styling */
                            trix-toolbar .trix-button-group {
                                background-color: #EFF6FF;
                                border-radius: 0.5rem;
                                margin-bottom: 0.5rem;
                            }
                            
                            trix-toolbar .trix-button {
                                border-color: #DBEAFE;
                                background-color: white;
                                color: #1E40AF;
                            }
                            
                            trix-toolbar .trix-button:hover {
                                background-color: #DBEAFE;
                            }
                            
                            trix-toolbar .trix-button.trix-active {
                                background-color: #3B82F6;
                                color: white;
                            }
                            
                            trix-editor {
                                background: white;
                                border: 1px solid #D1D5DB;
                                border-radius: 0.5rem;
                                padding: 1rem;
                                min-height: 300px;
                            }
                            
                            trix-editor:focus {
                                outline: 2px solid #3B82F6;
                                outline-offset: 2px;
                            }
                            
                            .trix-content h1 {
                                font-size: 1.875rem;
                                font-weight: 700;
                                margin-top: 1rem;
                                margin-bottom: 0.5rem;
                                color: #1F2937;
                            }
                            
                            .trix-content strong {
                                font-weight: 600;
                                color: #1F2937;
                            }
                            
                            .trix-content ul, .trix-content ol {
                                margin-left: 1.5rem;
                                margin-top: 0.5rem;
                                margin-bottom: 0.5rem;
                            }
                            
                            .trix-content li {
                                margin-bottom: 0.25rem;
                            }
                            
                            .trix-content a {
                                color: #3B82F6;
                                text-decoration: underline;
                            }
                            
                            .trix-content blockquote {
                                border-left: 4px solid #3B82F6;
                                padding-left: 1rem;
                                margin: 1rem 0;
                                color: #6B7280;
                                font-style: italic;
                            }
                        </style>

                        <!-- Date and Time -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Date and Time</h3>
                                    <p class="text-sm text-gray-600">When will your event take place?</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'date','value' => __('Start Date & Time *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start Date & Time *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <input 
                                            id="date" 
                                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                            type="datetime-local" 
                                            name="date" 
                                            value="<?php echo e(old('date')); ?>"
                                            x-model="startDate"
                                            required
                                        />
                                        <p class="text-xs text-gray-500 mt-1">When does the event begin?</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('date'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('date')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'end_date','value' => __('End Date & Time *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'end_date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('End Date & Time *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <input 
                                            id="end_date" 
                                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                            :class="!validateDates() && endDate ? 'border-red-500' : ''"
                                            type="datetime-local" 
                                            name="end_date" 
                                            value="<?php echo e(old('end_date')); ?>"
                                            x-model="endDate"
                                            required
                                        />
                                        <p class="text-xs text-gray-500 mt-1">When does the event end?</p>
                                        <p x-show="!validateDates() && endDate" class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            ⚠️ End date must be after start date
                                        </p>
                                        <p x-show="validateDates() && endDate" class="text-green-500 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Valid date range
                                        </p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('end_date'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('end_date')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location and Venue -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Location Details</h3>
                                    <p class="text-sm text-gray-600">Where will attendees need to go?</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200" x-data="{ 
                                eventFormat: '<?php echo e(old('event_format', 'physical')); ?>' 
                            }">
                                <!-- Event Format Selection -->
                                <div class="mb-6">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => __('Event Format *'),'class' => 'text-gray-700 font-semibold mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Format *')),'class' => 'text-gray-700 font-semibold mb-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div class="grid grid-cols-3 gap-4">
                                        <label class="relative flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200"
                                               :class="eventFormat === 'physical' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 hover:border-blue-400'">
                                            <input type="radio" name="event_format" value="physical" x-model="eventFormat" class="sr-only" required>
                                            <div class="w-full text-center">
                                                <svg class="w-8 h-8 mx-auto mb-2" :class="eventFormat === 'physical' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <p class="font-bold text-sm" :class="eventFormat === 'physical' ? 'text-blue-600' : 'text-gray-700'">Physical</p>
                                                <p class="text-xs text-gray-500 mt-1">In-person venue</p>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200"
                                               :class="eventFormat === 'online' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 hover:border-blue-400'">
                                            <input type="radio" name="event_format" value="online" x-model="eventFormat" class="sr-only">
                                            <div class="w-full text-center">
                                                <svg class="w-8 h-8 mx-auto mb-2" :class="eventFormat === 'online' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="font-bold text-sm" :class="eventFormat === 'online' ? 'text-blue-600' : 'text-gray-700'">Online</p>
                                                <p class="text-xs text-gray-500 mt-1">Virtual event</p>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200"
                                               :class="eventFormat === 'hybrid' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 hover:border-blue-400'">
                                            <input type="radio" name="event_format" value="hybrid" x-model="eventFormat" class="sr-only">
                                            <div class="w-full text-center">
                                                <svg class="w-8 h-8 mx-auto mb-2" :class="eventFormat === 'hybrid' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <p class="font-bold text-sm" :class="eventFormat === 'hybrid' ? 'text-blue-600' : 'text-gray-700'">Hybrid</p>
                                                <p class="text-xs text-gray-500 mt-1">Both formats</p>
                                            </div>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">💡 Choose how attendees will participate in your event</p>
                                </div>

                                <!-- Physical/Hybrid Location Fields -->
                                <div x-show="eventFormat === 'physical' || eventFormat === 'hybrid'" class="space-y-6" x-data="{ 
                                    latitude: '<?php echo e(old('latitude')); ?>', 
                                    longitude: '<?php echo e(old('longitude')); ?>',
                                    hasCoordinates: <?php echo e(old('latitude') && old('longitude') ? 'true' : 'false'); ?>

                                }">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'location','value' => __('Full Address *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'location','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Full Address *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'location','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'location','value' => old('location'),'required' => old('event_format', 'physical') !== 'online','autocomplete' => 'off','placeholder' => 'Start typing address... (autocomplete enabled)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'location','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'location','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('location')),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('event_format', 'physical') !== 'online'),'autocomplete' => 'off','placeholder' => 'Start typing address... (autocomplete enabled)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <p class="text-xs text-gray-500 mt-1">📍 Start typing and select from suggestions for automatic map coordinates</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('location'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('location')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <!-- Latitude & Longitude (Auto-filled by Google Maps) -->
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'latitude','value' => __('Latitude'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'latitude','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Latitude')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <input 
                                                id="latitude" 
                                                type="number" 
                                                step="any" 
                                                name="latitude" 
                                                x-model="latitude"
                                                :value="old('latitude')"
                                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                                placeholder="Auto-filled" 
                                                readonly
                                            />
                                            <p class="text-xs text-gray-500 mt-1">🗺️ Auto-filled</p>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('latitude'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('latitude')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>

                                        <div>
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'longitude','value' => __('Longitude'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'longitude','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Longitude')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <input 
                                                id="longitude" 
                                                type="number" 
                                                step="any" 
                                                name="longitude" 
                                                x-model="longitude"
                                                :value="old('longitude')"
                                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                                placeholder="Auto-filled" 
                                                readonly
                                            />
                                            <p class="text-xs text-gray-500 mt-1">🗺️ Auto-filled</p>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('longitude'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('longitude')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'country_code','value' => __('Country Code'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'country_code','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Country Code')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <input 
                                                id="country_code" 
                                                type="text" 
                                                name="country_code" 
                                                value="<?php echo e(old('country_code')); ?>"
                                                maxlength="2"
                                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full uppercase" 
                                                placeholder="US" 
                                                readonly
                                            />
                                            <p class="text-xs text-gray-500 mt-1">🌍 Auto-filled</p>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('country_code'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('country_code')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Coordinate Status Indicator -->
                                    <div x-show="latitude && longitude" class="p-4 bg-green-50 border-2 border-green-300 rounded-xl flex items-center gap-3">
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-bold text-green-800">✓ Location coordinates captured!</p>
                                            <p class="text-xs text-green-700">Your event will be displayed on the map at (<span x-text="parseFloat(latitude).toFixed(4)"></span>, <span x-text="parseFloat(longitude).toFixed(4)"></span>)</p>
                                        </div>
                                    </div>

                                    <div x-show="!latitude || !longitude" class="p-4 bg-amber-50 border-2 border-amber-300 rounded-xl flex items-center gap-3">
                                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-bold text-amber-800">⚠️ Select address from autocomplete suggestions</p>
                                            <p class="text-xs text-amber-700">This ensures your event appears on the map with accurate location</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'venue_name','value' => __('Venue Name'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'venue_name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Venue Name')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'venue_name','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'venue_name','value' => old('venue_name'),'placeholder' => 'e.g., Grand Convention Center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'venue_name','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'venue_name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('venue_name')),'placeholder' => 'e.g., Grand Convention Center']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                            <p class="text-xs text-gray-500 mt-1">Name of the building or venue</p>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('venue_name'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('venue_name')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>

                                        <div>
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'room_details','value' => __('Room/Hall Details'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'room_details','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Room/Hall Details')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'room_details','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'room_details','value' => old('room_details'),'placeholder' => 'e.g., Hall A, 3rd Floor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'room_details','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'room_details','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('room_details')),'placeholder' => 'e.g., Hall A, 3rd Floor']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                            <p class="text-xs text-gray-500 mt-1">Specific room or area within the venue</p>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('room_details'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('room_details')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Online/Hybrid Event Link -->
                                <div x-show="eventFormat === 'online' || eventFormat === 'hybrid'" class="space-y-4">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'online_event_link','value' => __('Event Link *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'online_event_link','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Link *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'online_event_link','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'url','name' => 'online_event_link','value' => old('online_event_link'),'placeholder' => 'https://zoom.us/j/123456789 or https://meet.google.com/abc-defg-hij']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'online_event_link','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'url','name' => 'online_event_link','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('online_event_link')),'placeholder' => 'https://zoom.us/j/123456789 or https://meet.google.com/abc-defg-hij']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <p class="text-xs text-gray-500 mt-1">🔗 Zoom, Google Meet, Teams, or any other meeting platform link</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('online_event_link'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('online_event_link')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div class="bg-blue-100 border border-blue-300 rounded-lg p-4">
                                        <p class="text-sm text-blue-800 font-semibold mb-2">💡 Online Event Tips:</p>
                                        <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                                            <li>Test your link before the event starts</li>
                                            <li>Consider sending the link via email before the event</li>
                                            <li>Have a backup communication method ready</li>
                                            <li>For hybrid events, ensure online attendees can participate fully</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Capacity and Pricing -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Capacity and Pricing</h3>
                                    <p class="text-sm text-gray-600">How many people can attend and what will it cost?</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'capacity','value' => __('Maximum Capacity *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'capacity','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Maximum Capacity *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <input 
                                            id="capacity" 
                                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                            type="number" 
                                            name="capacity" 
                                            value="<?php echo e(old('capacity', 100)); ?>"
                                            x-model.number="capacity"
                                            @input="expectedAttendance = Math.floor(capacity * 0.7)"
                                            min="1" 
                                            required 
                                            placeholder="e.g., 100"
                                        />
                                        <p class="text-xs text-gray-500 mt-1">Total number of people who can attend</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('capacity'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('capacity')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'price','value' => __('Ticket Price ($) *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'price','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Ticket Price ($) *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <input 
                                            id="price" 
                                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm block mt-1 w-full" 
                                            type="number" 
                                            step="0.01" 
                                            name="price" 
                                            value="<?php echo e(old('price', 0)); ?>"
                                            x-model.number="price"
                                            min="0" 
                                            required 
                                            placeholder="0.00"
                                        />
                                        <p class="text-xs text-gray-500 mt-1">Enter 0.00 for free events</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('price'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('price')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'event_type','value' => __('Event Type *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'event_type','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Type *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <select id="event_type" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" name="event_type" required>
                                            <option value="">Select event type</option>
                                            <option value="public" <?php echo e(old('event_type') == 'public' ? 'selected' : ''); ?>>Public (Open to everyone)</option>
                                            <option value="private" <?php echo e(old('event_type') == 'private' ? 'selected' : ''); ?>>Private (Invitation only)</option>
                                            <option value="vip" <?php echo e(old('event_type') == 'vip' ? 'selected' : ''); ?>>VIP (Exclusive access)</option>
                                            <option value="corporate" <?php echo e(old('event_type') == 'corporate' ? 'selected' : ''); ?>>Corporate (Business event)</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Who can attend this event?</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('event_type'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('event_type')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>

                                <!-- Revenue Calculator -->
                                <div x-show="price > 0" class="mt-6">
                                    <div class="bg-white rounded-xl p-5 border-2 border-blue-300 shadow-md">
                                        <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                            </svg>
                                            💰 Revenue Projection Calculator
                                        </h4>
                                        
                                        <div class="mb-4">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                                Expected Attendance: <span x-text="expectedAttendance"></span> attendees 
                                                (<span x-text="Math.round((expectedAttendance / capacity) * 100)"></span>%)
                                            </label>
                                            <input 
                                                type="range" 
                                                x-model="expectedAttendance" 
                                                :min="1"
                                                :max="capacity"
                                                class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer"
                                            />
                                        </div>

                                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-300">
                                            <p class="text-xs text-gray-700 mb-1 font-semibold">Projected Revenue</p>
                                            <p class="text-3xl font-black text-green-600">
                                                $<span x-text="calculateRevenue()"></span>
                                            </p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                Based on <span x-text="expectedAttendance"></span> attendees at $<span x-text="parseFloat(price).toFixed(2)"></span> each
                                            </p>
                                        </div>

                                        <!-- Quick Pricing Suggestions -->
                                        <div class="mt-4">
                                            <p class="text-xs font-bold text-gray-700 mb-2">💡 Quick Pricing Suggestions:</p>
                                            <div class="grid grid-cols-3 gap-2">
                                                <button 
                                                    @click.prevent="price = 0"
                                                    type="button"
                                                    data-price-suggestion
                                                    class="px-3 py-2 bg-white border-2 border-blue-300 rounded-lg text-xs font-semibold hover:bg-blue-50 transition-colors text-center"
                                                >
                                                    <div class="text-blue-600 font-bold">FREE</div>
                                                    <div class="text-gray-600 text-xs mt-0.5">Max attendance</div>
                                                </button>
                                                <button 
                                                    @click.prevent="price = 10"
                                                    type="button"
                                                    data-price-suggestion
                                                    data-price="10"
                                                    class="px-3 py-2 bg-white border-2 border-blue-300 rounded-lg text-xs font-semibold hover:bg-blue-50 transition-colors text-center"
                                                >
                                                    <div class="text-blue-600 font-bold">$10</div>
                                                    <div class="text-gray-600 text-xs mt-0.5">Cover costs</div>
                                                </button>
                                                <button 
                                                    @click.prevent="price = 25"
                                                    type="button"
                                                    data-price-suggestion
                                                    data-price="25"
                                                    class="px-3 py-2 bg-white border-2 border-blue-300 rounded-lg text-xs font-semibold hover:bg-blue-50 transition-colors text-center"
                                                >
                                                    <div class="text-blue-600 font-bold">$25</div>
                                                    <div class="text-gray-600 text-xs mt-0.5">Premium</div>
                                                </button>
                                            </div>
                                            
                                            <!-- Platform Fee & Profit Calculator -->
                                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                                <p class="text-xs font-bold text-gray-700 mb-2">💼 Profit After Platform Fee (10%)</p>
                                                <div class="grid grid-cols-2 gap-2 text-xs">
                                                    <div>
                                                        <span class="text-gray-600">Platform Fee:</span>
                                                        <span class="font-bold text-red-600">-$<span x-text="(calculateRevenue() * 0.10).toFixed(2)"></span></span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-600">Your Profit:</span>
                                                        <span class="font-bold text-green-600">$<span x-text="(calculateRevenue() * 0.90).toFixed(2)"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organizer Information -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Organizer Information</h3>
                                    <p class="text-sm text-gray-600">Who should attendees contact about this event?</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'organizer_name','value' => __('Organizer Name'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'organizer_name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Organizer Name')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'organizer_name','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'organizer_name','value' => old('organizer_name'),'placeholder' => 'Full name or organization']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'organizer_name','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'text','name' => 'organizer_name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('organizer_name')),'placeholder' => 'Full name or organization']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <p class="text-xs text-gray-500 mt-1">Who is organizing this event?</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('organizer_name'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('organizer_name')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'organizer_email','value' => __('Contact Email *'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'organizer_email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contact Email *')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'organizer_email','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'email','name' => 'organizer_email','value' => old('organizer_email'),'required' => true,'placeholder' => 'email@example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'organizer_email','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'email','name' => 'organizer_email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('organizer_email')),'required' => true,'placeholder' => 'email@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <p class="text-xs text-gray-500 mt-1">Where attendees can reach you</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('organizer_email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('organizer_email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'organizer_phone','value' => __('Contact Phone'),'class' => 'text-gray-700 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'organizer_phone','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contact Phone')),'class' => 'text-gray-700 font-semibold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'organizer_phone','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'tel','name' => 'organizer_phone','value' => old('organizer_phone'),'placeholder' => '+1 (555) 123-4567']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'organizer_phone','class' => 'block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg','type' => 'tel','name' => 'organizer_phone','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('organizer_phone')),'placeholder' => '+1 (555) 123-4567']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <p class="text-xs text-gray-500 mt-1">Optional phone number for inquiries</p>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('organizer_phone'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('organizer_phone')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload Section -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Event Media</h3>
                                    <p class="text-sm text-gray-600">Upload images to showcase your event - images will be displayed in a 3-column gallery</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200 space-y-6">
                                <!-- Enhanced Images Upload with Advanced Features -->
                                <div>
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'images','value' => __('Event Images * (Max 10MB each)'),'class' => 'text-gray-700 font-semibold mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'images','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Images * (Max 10MB each)')),'class' => 'text-gray-700 font-semibold mb-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div x-data="{ 
                                        images: [], 
                                        captions: {},
                                        dragOver: false,
                                        fileInput: null,
                                        init() {
                                            this.fileInput = this.$refs.imageInput;
                                        },
                                        handleFiles(event) {
                                            const files = Array.from(event.target.files);
                                            this.addImages(files);
                                        },
                                        handleDrop(e) {
                                            this.dragOver = false;
                                            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                                            this.addImages(files);
                                        },
                                        addImages(files) {
                                            files.forEach((file) => {
                                                if (file.size > 10 * 1024 * 1024) {
                                                    alert(file.name + ' is larger than 10MB. Please choose a smaller image.');
                                                    return;
                                                }
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    const index = this.images.length;
                                                    this.images.push({
                                                        file: file,
                                                        preview: e.target.result,
                                                        name: file.name,
                                                        size: file.size
                                                    });
                                                    this.captions[index] = '';
                                                };
                                                reader.readAsDataURL(file);
                                            });
                                        },
                                        removeImage(index) {
                                            this.images.splice(index, 1);
                                            const newCaptions = {};
                                            Object.keys(this.captions).forEach(key => {
                                                const idx = parseInt(key);
                                                if (idx < index) {
                                                    newCaptions[idx] = this.captions[key];
                                                } else if (idx > index) {
                                                    newCaptions[idx - 1] = this.captions[key];
                                                }
                                            });
                                            this.captions = newCaptions;
                                        },
                                        setFeatured(index) {
                                            if (index === 0) return;
                                            [this.images[0], this.images[index]] = [this.images[index], this.images[0]];
                                            [this.captions[0], this.captions[index]] = [this.captions[index], this.captions[0]];
                                        },
                                        moveImage(index, direction) {
                                            const newIndex = direction === 'left' ? index - 1 : index + 1;
                                            if (newIndex < 0 || newIndex >= this.images.length) return;
                                            [this.images[index], this.images[newIndex]] = [this.images[newIndex], this.images[index]];
                                            [this.captions[index], this.captions[newIndex]] = [this.captions[newIndex], this.captions[index]];
                                        },
                                        formatFileSize(bytes) {
                                            if (bytes < 1024) return bytes + ' B';
                                            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                                            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                                        }
                                    }" class="space-y-3">
                                        <!-- Drag & Drop Zone -->
                                        <div 
                                            @drop.prevent="handleDrop($event)"
                                            @dragover.prevent="dragOver = true"
                                            @dragleave="dragOver = false"
                                            :class="dragOver ? 'border-blue-600 bg-blue-100' : 'border-blue-300'"
                                            class="relative border-4 border-dashed rounded-xl p-12 transition-all duration-300 bg-white"
                                        >
                                            <input 
                                                type="file" 
                                                x-ref="imageInput"
                                                id="images" 
                                                name="images[]" 
                                                multiple 
                                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                @change="handleFiles($event)" 
                                            />
                                            <div class="text-center pointer-events-none">
                                                <div class="relative inline-block">
                                                    <svg class="w-20 h-20 text-blue-500 mx-auto mb-4" 
                                                         :class="dragOver ? 'animate-bounce' : ''" 
                                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                    <span x-show="dragOver" class="absolute top-0 right-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <p class="text-xl font-bold text-gray-700 mb-2">Drop images here</p>
                                                <p class="text-sm text-gray-500">or click to browse</p>
                                                <div class="mt-4 flex justify-center gap-2">
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">Max 10MB</span>
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">JPG, PNG, WEBP</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Advanced Image Preview with Sorting & Removal -->
                                        <div x-show="images.length > 0" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <template x-for="(image, index) in images" :key="index">
                                                <div class="group relative bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition-all duration-300">
                                                    <!-- Featured Badge -->
                                                    <button 
                                                        @click.prevent="setFeatured(index)"
                                                        type="button"
                                                        x-show="index === 0"
                                                        class="absolute top-2 left-2 z-10 px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1"
                                                    >
                                                        ⭐ Featured
                                                    </button>
                                                    
                                                    <!-- Set as Featured Button -->
                                                    <button 
                                                        @click.prevent="setFeatured(index)"
                                                        type="button"
                                                        x-show="index !== 0"
                                                        class="absolute top-2 left-2 z-10 px-3 py-1 bg-gray-600/80 text-white text-xs font-semibold rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                                    >
                                                        Set as Featured
                                                    </button>

                                                    <!-- Remove Button -->
                                                    <button 
                                                        @click.prevent="removeImage(index)"
                                                        type="button"
                                                        class="absolute top-2 right-2 z-10 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-200"
                                                    >
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>

                                                    <!-- Image Preview -->
                                                    <div class="relative h-48 overflow-hidden bg-gray-100">
                                                        <img :src="image.preview" :alt="image.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                        
                                                        <!-- Image Info Overlay -->
                                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                                                <p class="text-white text-xs font-semibold truncate" x-text="image.name"></p>
                                                                <p class="text-gray-300 text-xs" x-text="formatFileSize(image.size)"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Caption Input with Character Counter -->
                                                    <div class="p-4 bg-gradient-to-br from-blue-50 to-white">
                                                        <label class="block text-xs font-bold text-gray-700 mb-2">
                                                            📝 Image Description <span class="text-gray-400 font-normal">(<span x-text="(captions[index] || '').length"></span>/200)</span>
                                                        </label>
                                                        <textarea
                                                            x-model="captions[index]"
                                                            :name="'image_captions[' + index + ']'"
                                                            maxlength="200"
                                                            rows="2"
                                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                                            :placeholder="index === 0 ? 'Main event image - describe what attendees will see' : 'Additional context about this image'"
                                                        ></textarea>
                                                    </div>

                                                    <!-- Reorder Buttons -->
                                                    <div class="flex gap-2 p-3 bg-gray-50 border-t border-gray-200">
                                                        <button 
                                                            @click.prevent="moveImage(index, 'left')"
                                                            type="button"
                                                            x-show="index > 0"
                                                            class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors"
                                                        >
                                                            ← Move Left
                                                        </button>
                                                        <button 
                                                            @click.prevent="moveImage(index, 'right')"
                                                            type="button"
                                                            x-show="index < images.length - 1"
                                                            class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors"
                                                        >
                                                            Move Right →
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Image Count & Tips -->
                                        <div x-show="images.length > 0" class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                            <div class="flex items-start gap-3">
                                                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="font-bold text-gray-900 text-sm mb-2">
                                                        <span x-text="images.length"></span> image(s) selected
                                                    </p>
                                                    <ul class="text-xs text-gray-700 space-y-1 list-disc list-inside">
                                                        <li>First image will be the featured image shown in event listings</li>
                                                        <li>Add descriptions to help attendees understand each image</li>
                                                        <li>Use "Move" buttons to reorder images</li>
                                                        <li>Recommended: Use high-quality images (1920x1080 or larger)</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('images.*'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('images.*')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>

                                <!-- Videos Upload -->
                                <div>
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'videos','value' => __('Event Videos (Optional, Max 100MB each)'),'class' => 'text-gray-700 font-semibold mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'videos','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Event Videos (Optional, Max 100MB each)')),'class' => 'text-gray-700 font-semibold mb-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div x-data="{ videos: [] }" class="space-y-3">
                                        <div class="relative border-2 border-dashed border-blue-300 rounded-xl p-8 text-center hover:border-blue-500 transition-all duration-300 bg-white">
                                            <input type="file" id="videos" name="videos[]" multiple accept="video/mp4,video/mov,video/avi,video/wmv,video/flv" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                   @change="videos = Array.from($event.target.files)" />
                                            <div class="pointer-events-none">
                                                <svg class="mx-auto h-16 w-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="mt-3 text-sm text-gray-700">
                                                    <span class="font-semibold text-blue-600">Click to upload videos</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 mt-2">MP4, MOV, AVI, WMV, FLV up to 100MB each</p>
                                            </div>
                                        </div>
                                        <div x-show="videos.length > 0" class="bg-blue-100 rounded-xl p-4">
                                            <p class="text-gray-800 font-semibold mb-2">Selected Videos:</p>
                                            <ul class="space-y-2">
                                                <template x-for="video in videos" :key="video.name">
                                                    <li class="text-sm text-gray-700 flex items-center gap-2 bg-white p-2 rounded-lg">
                                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span x-text="video.name" class="flex-1"></span>
                                                        <span x-text="(video.size / 1024 / 1024).toFixed(2) + ' MB'" class="text-xs text-gray-500"></span>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('videos.*'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('videos.*')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Agreements -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Publish Settings & Terms</h3>
                                    <p class="text-sm text-gray-600">Choose how to publish and review terms</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <!-- Publish Status Selection (NEW MVP FEATURE) -->
                                <div class="mb-6" x-data="{ publishStatus: '<?php echo e(old('status', 'draft')); ?>' }">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => __('Publication Status *'),'class' => 'text-gray-700 font-semibold mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Publication Status *')),'class' => 'text-gray-700 font-semibold mb-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative flex items-center p-5 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200"
                                               :class="publishStatus === 'draft' ? 'border-blue-600 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-300 hover:border-blue-400'">
                                            <input type="radio" name="status" value="draft" x-model="publishStatus" class="sr-only" required>
                                            <div class="w-full">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <svg class="w-6 h-6" :class="publishStatus === 'draft' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="font-bold text-sm" :class="publishStatus === 'draft' ? 'text-blue-600' : 'text-gray-700'">Save as Draft</p>
                                                        <p class="text-xs text-gray-500 mt-0.5">Review & edit later before publishing</p>
                                                    </div>
                                                </div>
                                                <div class="ml-9">
                                                    <p class="text-xs text-gray-600">✓ Not visible to public</p>
                                                    <p class="text-xs text-gray-600">✓ Can edit anytime</p>
                                                    <p class="text-xs text-gray-600">✓ Publish when ready</p>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-5 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200"
                                               :class="publishStatus === 'published' ? 'border-green-600 bg-green-50 ring-2 ring-green-200' : 'border-gray-300 hover:border-green-400'">
                                            <input type="radio" name="status" value="published" x-model="publishStatus" class="sr-only">
                                            <div class="w-full">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <svg class="w-6 h-6" :class="publishStatus === 'published' ? 'text-green-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="font-bold text-sm" :class="publishStatus === 'published' ? 'text-green-600' : 'text-gray-700'">Publish Immediately</p>
                                                        <p class="text-xs text-gray-500 mt-0.5">Event goes live right away</p>
                                                    </div>
                                                </div>
                                                <div class="ml-9">
                                                    <p class="text-xs text-gray-600">✓ Visible to everyone</p>
                                                    <p class="text-xs text-gray-600">✓ Accepts registrations</p>
                                                    <p class="text-xs text-gray-600">✓ Appears in search</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div x-show="publishStatus === 'published'" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-sm text-green-800 font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            Ready to publish? Make sure all information is correct!
                                        </p>
                                        <p class="text-xs text-green-700 mt-1">Your event will be visible to everyone and start accepting registrations immediately.</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <h4 class="font-bold text-gray-800 mb-2">Event Terms & Conditions:</h4>
                                        <ul class="text-sm text-gray-700 space-y-2 list-disc list-inside">
                                            <li>All information provided must be accurate and truthful</li>
                                            <li>Event organizer is responsible for event safety and compliance with local regulations</li>
                                            <li>Refund policy must be clearly communicated to attendees</li>
                                            <li>Event can be cancelled or modified only with proper notice to all registered attendees</li>
                                            <li>Platform reserves the right to remove events that violate community guidelines</li>
                                            <li>All payments will be processed securely through our payment gateway</li>
                                        </ul>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" id="terms" name="terms" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="terms" class="text-sm text-gray-700">
                                            I have read and agree to the <span class="font-semibold text-blue-600">Terms and Conditions</span>. 
                                            I confirm that all information provided is accurate and I understand my responsibilities as an event organizer. <span class="text-red-600">*</span>
                                        </label>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" id="cancellation_policy" name="cancellation_policy" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="cancellation_policy" class="text-sm text-gray-700">
                                            I acknowledge that I will provide a clear <span class="font-semibold text-blue-600">cancellation and refund policy</span> to all attendees. <span class="text-red-600">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between gap-4" x-data="{ showPreview: false }">
                            <div class="flex items-center gap-4">
                                <p class="text-sm text-gray-600">
                                    <span class="text-red-600 text-lg">*</span> Required fields
                                </p>
                                <button 
                                    @click.prevent="showPreview = !showPreview" 
                                    type="button" 
                                    class="px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span x-text="showPreview ? 'Hide Preview' : 'Preview Event'"></span>
                                </button>
                            </div>
                            <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Submit for Approval</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.google_maps.api_key')): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('services.google_maps.api_key')); ?>&libraries=places&loading=async" async defer></script>
    <script src="<?php echo e(asset('js/event-form-enhancements.js')); ?>" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for Google Maps to load
            function initAutocomplete() {
                const locationInput = document.getElementById('location');
                if (!locationInput) return;

                // Initialize autocomplete
                const autocomplete = new google.maps.places.Autocomplete(locationInput, {
                    types: ['establishment', 'geocode'],
                    fields: ['formatted_address', 'geometry', 'name', 'address_components', 'place_id']
                });

                // Listen for place selection
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    
                    if (!place.geometry) {
                        console.warn('No geometry found for selected place');
                        return;
                    }

                    // Extract coordinates
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();

                    // Update hidden latitude and longitude fields
                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');
                    
                    if (latInput && lngInput) {
                        latInput.value = lat;
                        lngInput.value = lng;
                        
                        // Extract country code from address components
                        let countryCode = '';
                        if (place.address_components) {
                            place.address_components.forEach(component => {
                                if (component.types.includes('country')) {
                                    countryCode = component.short_name;
                                }
                            });
                        }
                        
                        // Update country code field
                        const countryCodeInput = document.getElementById('country_code');
                        if (countryCodeInput && countryCode) {
                            countryCodeInput.value = countryCode;
                        }
                        
                        // Trigger Alpine.js update if using Alpine
                        latInput.dispatchEvent(new Event('input'));
                        lngInput.dispatchEvent(new Event('input'));
                        
                        console.log('✅ Location coordinates captured:', lat, lng, 'Country:', countryCode);
                        
                        // Show notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        notification.textContent = '✓ Location coordinates & country captured! Event will appear on map';
                        document.body.appendChild(notification);
                        setTimeout(() => notification.remove(), 3000);
                    }

                    // Update location input with formatted address
                    locationInput.value = place.formatted_address || place.name;
                });
            }

            // Check if Google Maps is loaded
            if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                initAutocomplete();
            } else {
                // Wait for Google Maps to load
                window.addEventListener('load', function() {
                    setTimeout(initAutocomplete, 500);
                });
            }
        });
    </script>
    <?php else: ?>
    <script>
        console.warn('⚠️ Google Maps API key not configured. Address autocomplete disabled.');
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/event_requests/create.blade.php ENDPATH**/ ?>