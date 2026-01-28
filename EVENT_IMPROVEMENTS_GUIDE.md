# Event Creation & Presentation Improvements

## Current Analysis

After reviewing your event creation form (`events/create.blade.php`) and event display page (`events/show.blade.php`), here are comprehensive improvements to enhance quality, ease of understanding, and user interaction:

---

## 🎯 **Priority Improvements**

### **1. Real-Time Form Validation & Feedback** ⚡

**Current Issue:**
- Users only see errors after form submission
- No real-time feedback on field validity
- Price field allows negative values despite min="0"

**Improvements:**
```blade
<!-- Add Alpine.js validation states -->
<div x-data="{
    eventName: '',
    isValidName: false,
    capacity: null,
    price: null,
    startDate: '',
    endDate: '',
    validateDates() {
        if(this.startDate && this.endDate) {
            return new Date(this.endDate) > new Date(this.startDate);
        }
        return true;
    }
}">

<!-- Event Name with real-time validation -->
<input 
    x-model="eventName"
    @input="isValidName = eventName.length >= 3"
    :class="eventName.length > 0 && !isValidName ? 'border-red-500' : 'border-green-500'"
/>
<p x-show="eventName.length > 0 && !isValidName" class="text-red-500 text-xs">
    Event name must be at least 3 characters
</p>
<p x-show="isValidName" class="text-green-500 text-xs flex items-center gap-1">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
    </svg>
    Looks good!
</p>

<!-- Date validation with visual feedback -->
<p x-show="!validateDates() && endDate" class="text-red-500 text-xs">
    ⚠️ End date must be after start date
</p>
</div>
```

**Benefits:**
- ✅ Immediate feedback reduces form abandonment
- ✅ Visual confirmation (green checkmarks) builds confidence
- ✅ Reduces server-side validation errors

---

### **2. Enhanced Image Preview System** 🖼️

**Current Issue:**
- Basic image preview in 3-column grid
- No image cropping/optimization preview
- No featured image selection
- Limited image management (no reordering, no removal)

**Improvements:**
```blade
<div x-data="imageManager()">
    <!-- Drag & Drop Zone with better visual feedback -->
    <div 
        @drop.prevent="handleDrop($event)"
        @dragover.prevent="dragOver = true"
        @dragleave="dragOver = false"
        :class="dragOver ? 'border-blue-600 bg-blue-100' : 'border-blue-300'"
        class="border-4 border-dashed rounded-xl p-12 transition-all duration-300"
    >
        <div class="text-center">
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
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <template x-for="(image, index) in images" :key="index">
            <div class="group relative bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition-all duration-300">
                <!-- Featured Badge -->
                <button 
                    @click="setFeatured(index)"
                    type="button"
                    x-show="index === 0"
                    class="absolute top-2 left-2 z-10 px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1"
                >
                    ⭐ Featured
                </button>
                
                <!-- Set as Featured Button -->
                <button 
                    @click="setFeatured(index)"
                    type="button"
                    x-show="index !== 0"
                    class="absolute top-2 left-2 z-10 px-3 py-1 bg-gray-600/80 text-white text-xs font-semibold rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                >
                    Set as Featured
                </button>

                <!-- Remove Button -->
                <button 
                    @click="removeImage(index)"
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
                        @click="moveImage(index, 'left')"
                        type="button"
                        x-show="index > 0"
                        class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors"
                    >
                        ← Move Left
                    </button>
                    <button 
                        @click="moveImage(index, 'right')"
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
                    <li>Drag images to reorder or click "Move" buttons</li>
                    <li>Recommended: Use high-quality images (1920x1080 or larger)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function imageManager() {
    return {
        images: [],
        captions: {},
        dragOver: false,
        
        handleDrop(e) {
            this.dragOver = false;
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            this.addImages(files);
        },
        
        addImages(files) {
            files.forEach((file, idx) => {
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
            delete this.captions[index];
            // Reindex captions
            const newCaptions = {};
            Object.keys(this.captions).forEach(key => {
                const idx = parseInt(key);
                if (idx > index) {
                    newCaptions[idx - 1] = this.captions[key];
                } else if (idx < index) {
                    newCaptions[idx] = this.captions[key];
                }
            });
            this.captions = newCaptions;
        },
        
        setFeatured(index) {
            if (index === 0) return;
            const temp = this.images[0];
            this.images[0] = this.images[index];
            this.images[index] = temp;
            
            const tempCaption = this.captions[0];
            this.captions[0] = this.captions[index];
            this.captions[index] = tempCaption;
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
    }
}
</script>
```

**Benefits:**
- ✅ Drag & drop with visual feedback
- ✅ Image reordering (drag or buttons)
- ✅ Featured image selection
- ✅ Individual image removal
- ✅ Character counter for captions
- ✅ File size validation
- ✅ Professional image management

---

### **3. Progress Indicator & Form Steps** 📊

**Current Issue:**
- Long single-page form can be overwhelming
- No indication of completion progress
- Users don't know how much is left

**Improvements:**
```blade
<!-- Add to top of form -->
<div x-data="{ currentStep: 1, totalSteps: 6 }" class="mb-8">
    <!-- Progress Bar -->
    <div class="relative">
        <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-200">
            <div 
                :style="'width: ' + ((currentStep / totalSteps) * 100) + '%'" 
                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-500"
            ></div>
        </div>
        <p class="text-center text-sm text-gray-600 mt-2 font-semibold">
            Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>
            (<span x-text="Math.round((currentStep / totalSteps) * 100)"></span>% complete)
        </p>
    </div>

    <!-- Step Indicators -->
    <div class="mt-6 grid grid-cols-6 gap-2">
        <template x-for="step in totalSteps" :key="step">
            <div 
                @click="currentStep = step"
                class="cursor-pointer text-center"
            >
                <div 
                    :class="step <= currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
                    class="w-10 h-10 mx-auto rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 hover:scale-110"
                >
                    <span x-text="step"></span>
                </div>
                <p 
                    :class="step === currentStep ? 'text-blue-600 font-bold' : 'text-gray-500'"
                    class="text-xs mt-2 transition-colors duration-300"
                    x-text="getStepName(step)"
                ></p>
            </div>
        </template>
    </div>
</div>

<script>
function getStepName(step) {
    const names = {
        1: 'Basic Info',
        2: 'Description',
        3: 'Date & Time',
        4: 'Location',
        5: 'Media',
        6: 'Review'
    };
    return names[step] || 'Step ' + step;
}
</script>
```

---

### **4. Smart Field Suggestions & Auto-Complete** 🧠

**Improvements:**
```blade
<!-- Venue Auto-Complete -->
<div x-data="{ venues: [], selectedVenue: null, search: '' }">
    <input 
        type="text"
        x-model="search"
        @input.debounce.300ms="fetchVenues"
        placeholder="Start typing venue name..."
        class="w-full px-4 py-3 border border-gray-300 rounded-lg"
    />
    
    <!-- Suggestions Dropdown -->
    <div x-show="venues.length > 0" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
        <template x-for="venue in venues" :key="venue.id">
            <div 
                @click="selectVenue(venue)"
                class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 transition-colors"
            >
                <p class="font-semibold text-gray-900" x-text="venue.name"></p>
                <p class="text-sm text-gray-600" x-text="venue.address"></p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full" x-text="'Capacity: ' + venue.capacity"></span>
                    <span class="text-xs text-gray-500" x-text="venue.distance + ' miles away'"></span>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Category Suggestions Based on Title -->
<div x-data="{ suggestedCategory: null }">
    <input 
        @input.debounce="suggestCategory($event.target.value)"
        placeholder="Event Name"
    />
    
    <p x-show="suggestedCategory" class="mt-2 text-sm text-blue-600 flex items-center gap-2">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        Suggested category: <span class="font-bold" x-text="suggestedCategory"></span>
        <button @click="setCategory(suggestedCategory)" type="button" class="text-blue-600 underline">Use this</button>
    </p>
</div>
```

---

### **5. Enhanced Event Display Page** 🎨

**Current Issue:**
- Basic grid layout, not visually engaging
- No interactive elements (maps, social sharing)
- Limited information hierarchy
- No call-to-action prominence

**Improvements:**

```blade
<!-- Hero Section with Featured Image -->
<div class="relative h-96 overflow-hidden rounded-3xl shadow-2xl mb-8">
    @if($event->featuredImage)
        <img src="{{ Storage::url($event->featuredImage->file_path) }}" 
             alt="{{ $event->name }}" 
             class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800"></div>
    @endif
    
    <!-- Event Title Overlay -->
    <div class="absolute bottom-0 left-0 right-0 p-8">
        <div class="max-w-4xl">
            <div class="flex items-center gap-3 mb-3">
                <span class="px-4 py-2 bg-blue-500 text-white font-bold rounded-full text-sm">
                    {{ $event->category ?? 'Event' }}
                </span>
                @if($event->price == 0)
                    <span class="px-4 py-2 bg-green-500 text-white font-bold rounded-full text-sm">
                        🎉 FREE
                    </span>
                @endif
            </div>
            <h1 class="text-5xl font-black text-white mb-4 drop-shadow-lg">
                {{ $event->name }}
            </h1>
            <div class="flex items-center gap-6 text-white/90">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">{{ $event->date->format('F j, Y • g:i A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">{{ $event->venue->name ?? $event->location }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Bar (Sticky) -->
<div class="sticky top-20 z-40 bg-white/95 backdrop-blur-lg shadow-lg rounded-2xl p-4 mb-8 border border-gray-200">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <!-- Attendee Count -->
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                    @for($i = 0; $i < min(3, $event->bookings_count); $i++)
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">
                            {{ substr($event->bookings[$i]->user->name ?? 'U', 0, 1) }}
                        </div>
                    @endfor
                </div>
                <span class="text-sm font-semibold text-gray-700">
                    <span class="text-blue-600">{{ $event->bookings_count }}</span> attending
                </span>
            </div>

            <!-- Spots Remaining -->
            @if($event->capacity)
                <div class="h-6 w-px bg-gray-300"></div>
                <div class="flex items-center gap-2">
                    <div class="relative w-8 h-8">
                        <svg class="transform -rotate-90 w-8 h-8">
                            <circle cx="16" cy="16" r="14" stroke="#E5E7EB" stroke-width="4" fill="none"/>
                            <circle 
                                cx="16" cy="16" r="14" 
                                stroke="#3B82F6" 
                                stroke-width="4" 
                                fill="none"
                                stroke-dasharray="{{ 2 * 3.14159 * 14 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 14 * (1 - $event->bookings_count / $event->capacity) }}"
                                stroke-linecap="round"
                            />
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-xs font-bold text-blue-600">
                            {{ $event->capacity - $event->bookings_count }}
                        </span>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">spots left</span>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            <!-- Share Button -->
            <button 
                @click="shareEvent()"
                class="px-4 py-2 border-2 border-blue-500 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-200"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
                Share
            </button>

            <!-- Book Now Button -->
            @if($event->bookings_count < $event->capacity)
                <a href="{{ route('bookings.create.for.event', $event) }}" 
                   class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    🎫 Book Now
                    @if($event->price > 0)
                        <span class="ml-2">${{ number_format($event->price, 2) }}</span>
                    @else
                        <span class="ml-2 text-yellow-300">FREE</span>
                    @endif
                </a>
            @else
                <div class="px-8 py-3 bg-gray-400 text-white font-bold rounded-xl cursor-not-allowed">
                    ❌ Sold Out
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Interactive Map (if location available) -->
<div class="mb-8">
    <h3 class="text-2xl font-bold text-gray-900 mb-4">📍 Location & Directions</h3>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold mb-1">Venue</p>
                        <p class="text-lg font-bold text-gray-900">{{ $event->venue->name ?? 'To Be Announced' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold mb-1">Address</p>
                        <p class="text-gray-800">{{ $event->location }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->location) }}" 
                           target="_blank"
                           class="flex-1 px-4 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition-colors text-center">
                            Open in Google Maps
                        </a>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $event->location }}')"
                            class="px-4 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                            Copy Address
                        </button>
                    </div>
                </div>
            </div>
            <div class="h-64 md:h-auto">
                <!-- Embed Google Maps iframe -->
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    style="border:0"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ urlencode($event->location) }}"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Image Gallery with Lightbox -->
<div x-data="{ 
    lightbox: false, 
    currentImage: 0,
    images: {{ $event->images->pluck('file_path')->toJson() }}
}">
    <h3 class="text-2xl font-bold text-gray-900 mb-4">🖼️ Event Gallery</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        @foreach($event->images as $index => $image)
            <div 
                @click="lightbox = true; currentImage = {{ $index }}"
                class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300"
            >
                <img 
                    src="{{ Storage::url($image->file_path) }}" 
                    alt="{{ $image->caption }}" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                @if($image->caption)
                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent">
                        <p class="text-white text-xs font-semibold truncate">{{ $image->caption }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div 
        x-show="lightbox" 
        x-cloak
        @click.self="lightbox = false"
        class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
    >
        <button @click="lightbox = false" class="absolute top-4 right-4 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
        
        <button @click="currentImage = currentImage > 0 ? currentImage - 1 : images.length - 1" class="absolute left-4 text-white hover:text-gray-300">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </button>
        
        <img 
            :src="'/storage/' + images[currentImage]" 
            class="max-h-[90vh] max-w-[90vw] object-contain"
        />
        
        <button @click="currentImage = currentImage < images.length - 1 ? currentImage + 1 : 0" class="absolute right-4 text-white hover:text-gray-300">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
        </button>
        
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white font-bold">
            <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>
</div>
```

---

### **6. Form Autosave & Recovery** 💾

**Improvements:**
```blade
<div x-data="formAutosave()">
    <form @input.debounce.1000ms="saveProgress">
        <!-- Your form fields -->
        
        <!-- Autosave Indicator -->
        <div class="fixed bottom-4 right-4 z-50">
            <div 
                x-show="saving"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-lg flex items-center gap-2"
            >
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            </div>
            
            <div 
                x-show="!saving && lastSaved"
                class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-lg"
            >
                ✓ Saved <span x-text="lastSaved"></span>
            </div>
        </div>
    </form>
</div>

<script>
function formAutosave() {
    return {
        saving: false,
        lastSaved: null,
        
        saveProgress() {
            this.saving = true;
            
            const formData = new FormData(this.$el.querySelector('form'));
            localStorage.setItem('event_draft', JSON.stringify(Object.fromEntries(formData)));
            
            setTimeout(() => {
                this.saving = false;
                this.lastSaved = 'just now';
            }, 500);
        },
        
        init() {
            // Restore draft on page load
            const draft = localStorage.getItem('event_draft');
            if (draft && confirm('Found unsaved event draft. Restore it?')) {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    const input = this.$el.querySelector(`[name="${key}"]`);
                    if (input) input.value = data[key];
                });
            }
        }
    }
}
</script>
```

---

### **7. Smart Pricing Calculator** 💰

**Improvements:**
```blade
<div x-data="{ 
    price: 0, 
    capacity: 100,
    expectedAttendance: 70,
    calculateRevenue() {
        return (this.price * this.expectedAttendance).toFixed(2);
    }
}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label>Ticket Price ($)</label>
            <input type="number" x-model="price" step="0.01" min="0" />
        </div>
        
        <div>
            <label>Expected Attendance (%)</label>
            <input 
                type="range" 
                x-model="expectedAttendance" 
                :min="1"
                :max="capacity"
                class="w-full"
            />
            <p class="text-sm text-gray-600 mt-1">
                <span x-text="expectedAttendance"></span> out of <span x-text="capacity"></span> attendees
                (<span x-text="Math.round((expectedAttendance / capacity) * 100)"></span>%)
            </p>
        </div>
    </div>

    <!-- Revenue Projection -->
    <div class="mt-4 p-4 bg-green-50 rounded-xl border-2 border-green-200">
        <p class="text-sm text-gray-700 mb-1">💰 Projected Revenue</p>
        <p class="text-3xl font-black text-green-600">
            $<span x-text="calculateRevenue()"></span>
        </p>
        <p class="text-xs text-gray-600 mt-1">
            Based on <span x-text="expectedAttendance"></span> attendees at $<span x-text="price"></span> each
        </p>
    </div>

    <!-- Pricing Suggestions -->
    <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
        <p class="text-sm font-bold text-gray-900 mb-2">💡 Pricing Suggestions:</p>
        <div class="space-y-2">
            <button 
                @click="price = 0"
                type="button"
                class="w-full px-4 py-2 bg-white border border-blue-300 rounded-lg text-left hover:bg-blue-100 transition-colors"
            >
                <span class="font-semibold">Free Event</span> - Maximize attendance
            </button>
            <button 
                @click="price = 10"
                type="button"
                class="w-full px-4 py-2 bg-white border border-blue-300 rounded-lg text-left hover:bg-blue-100 transition-colors"
            >
                <span class="font-semibold">$10</span> - Cover basic costs
            </button>
            <button 
                @click="price = 25"
                type="button"
                class="w-full px-4 py-2 bg-white border border-blue-300 rounded-lg text-left hover:bg-blue-100 transition-colors"
            >
                <span class="font-semibold">$25</span> - Premium experience
            </button>
        </div>
    </div>
</div>
```

---

## 📊 **Summary of Improvements**

| Feature | Current | Improved | Impact |
|---------|---------|----------|--------|
| Form Validation | Post-submit only | Real-time with visual feedback | ⭐⭐⭐⭐⭐ High |
| Image Management | Basic upload + preview | Drag-drop, reorder, captions, featured selection | ⭐⭐⭐⭐⭐ High |
| Progress Tracking | None | Step-by-step with progress bar | ⭐⭐⭐⭐ Medium-High |
| Auto-suggestions | None | Venue auto-complete, category suggestions | ⭐⭐⭐⭐ Medium-High |
| Event Display | Static grid | Hero image, interactive map, lightbox gallery | ⭐⭐⭐⭐⭐ High |
| Form Recovery | None | Auto-save with localStorage | ⭐⭐⭐ Medium |
| Pricing Tools | Basic input | Calculator with projections & suggestions | ⭐⭐⭐⭐ Medium-High |

---

## 🎯 **Quick Wins (Implement First)**

1. ✅ Real-time validation (30 min)
2. ✅ Enhanced image preview with removal (45 min)
3. ✅ Progress indicator (20 min)
4. ✅ Hero section on event page (30 min)
5. ✅ Share button functionality (15 min)

**Total Implementation Time: ~2-3 hours for core improvements**

---

## 🚀 **Next Phase Recommendations**

1. **Email Integration**: Send preview of event to organizer
2. **Social Proof**: Show "X people viewed this event today"
3. **Related Events**: "You might also like..."
4. **Reviews System**: Allow attendees to rate past events
5. **Calendar Export**: Add to Google Calendar, iCal
6. **WhatsApp/SMS Notifications**: Event reminders
7. **QR Code Check-in**: Live event dashboard

---

**Would you like me to implement any of these improvements now?**
