<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">
                        Create New Event
                    </h2>
                    <div class="h-1 w-24 bg-white/80 rounded-full mt-2"></div>
                    <p class="text-white/90 mt-2">Provide comprehensive details to help attendees understand your event</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf

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
                                    <div>
                                        <x-input-label for="name" :value="__('Event Name *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g., Annual Tech Conference 2026" />
                                        <p class="text-xs text-gray-500 mt-1">Choose a clear, descriptive name that tells people what your event is about</p>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="category" :value="__('Event Category *')" class="text-gray-700 font-semibold" />
                                        <select id="category" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" name="category" required>
                                            <option value="">Select a category</option>
                                            <option value="conference" {{ old('category') == 'conference' ? 'selected' : '' }}>Conference</option>
                                            <option value="workshop" {{ old('category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                            <option value="concert" {{ old('category') == 'concert' ? 'selected' : '' }}>Concert</option>
                                            <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                            <option value="exhibition" {{ old('category') == 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                            <option value="networking" {{ old('category') == 'networking' ? 'selected' : '' }}>Networking</option>
                                            <option value="seminar" {{ old('category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                            <option value="festival" {{ old('category') == 'festival' ? 'selected' : '' }}>Festival</option>
                                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">This helps attendees find your event when searching</p>
                                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                    </div>
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
                                <x-input-label for="description" :value="__('Detailed Description *')" class="text-gray-700 font-semibold mb-2" />
                                <p class="text-xs text-gray-600 mb-3">Use the editor below to format your event description. You can add headings, lists, bold text, and more.</p>
                                
                                <input id="description" type="hidden" name="description" value="{{ old('description') }}" required>
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
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
                                        <x-input-label for="date" :value="__('Start Date & Time *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="date" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="datetime-local" name="date" :value="old('date')" required />
                                        <p class="text-xs text-gray-500 mt-1">When does the event begin?</p>
                                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="end_date" :value="__('End Date & Time *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="end_date" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="datetime-local" name="end_date" :value="old('end_date')" required />
                                        <p class="text-xs text-gray-500 mt-1">When does the event end?</p>
                                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
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
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <x-input-label for="location" :value="__('Full Address *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="location" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="location" :value="old('location')" required autocomplete="location" placeholder="e.g., 123 Main Street, City, State, ZIP Code" />
                                        <p class="text-xs text-gray-500 mt-1">Provide the complete address so attendees can find your event</p>
                                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <x-input-label for="venue_name" :value="__('Venue Name')" class="text-gray-700 font-semibold" />
                                            <x-text-input id="venue_name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="venue_name" :value="old('venue_name')" placeholder="e.g., Grand Convention Center" />
                                            <p class="text-xs text-gray-500 mt-1">Name of the building or venue</p>
                                            <x-input-error :messages="$errors->get('venue_name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="room_details" :value="__('Room/Hall Details')" class="text-gray-700 font-semibold" />
                                            <x-text-input id="room_details" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="room_details" :value="old('room_details')" placeholder="e.g., Hall A, 3rd Floor" />
                                            <p class="text-xs text-gray-500 mt-1">Specific room or area within the venue</p>
                                            <x-input-error :messages="$errors->get('room_details')" class="mt-2" />
                                        </div>
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
                                        <x-input-label for="capacity" :value="__('Maximum Capacity *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="capacity" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="number" name="capacity" :value="old('capacity')" min="1" required placeholder="e.g., 100" />
                                        <p class="text-xs text-gray-500 mt-1">Total number of people who can attend</p>
                                        <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="price" :value="__('Ticket Price ($) *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="price" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="number" step="0.01" name="price" :value="old('price')" min="0" required placeholder="0.00" />
                                        <p class="text-xs text-gray-500 mt-1">Enter 0.00 for free events</p>
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="event_type" :value="__('Event Type *')" class="text-gray-700 font-semibold" />
                                        <select id="event_type" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" name="event_type" required>
                                            <option value="">Select event type</option>
                                            <option value="public" {{ old('event_type') == 'public' ? 'selected' : '' }}>Public (Open to everyone)</option>
                                            <option value="private" {{ old('event_type') == 'private' ? 'selected' : '' }}>Private (Invitation only)</option>
                                            <option value="vip" {{ old('event_type') == 'vip' ? 'selected' : '' }}>VIP (Exclusive access)</option>
                                            <option value="corporate" {{ old('event_type') == 'corporate' ? 'selected' : '' }}>Corporate (Business event)</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Who can attend this event?</p>
                                        <x-input-error :messages="$errors->get('event_type')" class="mt-2" />
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
                                        <x-input-label for="organizer_name" :value="__('Organizer Name')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="organizer_name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="organizer_name" :value="old('organizer_name')" placeholder="Full name or organization" />
                                        <p class="text-xs text-gray-500 mt-1">Who is organizing this event?</p>
                                        <x-input-error :messages="$errors->get('organizer_name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="organizer_email" :value="__('Contact Email *')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="organizer_email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="email" name="organizer_email" :value="old('organizer_email')" required placeholder="email@example.com" />
                                        <p class="text-xs text-gray-500 mt-1">Where attendees can reach you</p>
                                        <x-input-error :messages="$errors->get('organizer_email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="organizer_phone" :value="__('Contact Phone')" class="text-gray-700 font-semibold" />
                                        <x-text-input id="organizer_phone" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="tel" name="organizer_phone" :value="old('organizer_phone')" placeholder="+1 (555) 123-4567" />
                                        <p class="text-xs text-gray-500 mt-1">Optional phone number for inquiries</p>
                                        <x-input-error :messages="$errors->get('organizer_phone')" class="mt-2" />
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
                                <!-- Images Upload -->
                                <div>
                                    <x-input-label for="images" :value="__('Event Images * (Max 10MB each)')" class="text-gray-700 font-semibold mb-3" />
                                    <div x-data="{ 
                                        files: [], 
                                        previews: [],
                                        captions: {},
                                        handleFiles(event) {
                                            this.files = Array.from(event.target.files);
                                            this.previews = [];
                                            this.files.forEach((file, index) => {
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    this.previews.push({ 
                                                        name: file.name, 
                                                        url: e.target.result,
                                                        index: index 
                                                    });
                                                };
                                                reader.readAsDataURL(file);
                                                if (!this.captions[index]) {
                                                    this.captions[index] = '';
                                                }
                                            });
                                        }
                                    }" class="space-y-3">
                                        <div class="relative border-2 border-dashed border-blue-300 rounded-xl p-8 text-center hover:border-blue-500 transition-all duration-300 bg-white">
                                            <input type="file" 
                                                   id="images" 
                                                   name="images[]" 
                                                   multiple 
                                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                   @change="handleFiles($event)" />
                                            <div class="pointer-events-none">
                                                <svg class="mx-auto h-16 w-16 text-blue-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <p class="mt-3 text-sm text-gray-700">
                                                    <span class="font-semibold text-blue-600">Click to upload images</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF, WEBP up to 10MB each</p>
                                                <p class="text-xs text-blue-600 font-semibold mt-1">Upload multiple images - they'll be displayed in a 3-column gallery</p>
                                                <p class="text-xs text-green-600 font-semibold mt-2">✨ You can add descriptions for each image below!</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Image Preview Grid with Caption Inputs (3 Columns) -->
                                        <div x-show="previews.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                            <template x-for="(preview, index) in previews" :key="index">
                                                <div class="bg-white rounded-xl border-2 border-blue-200 shadow-md overflow-hidden">
                                                    <div class="relative group">
                                                        <img :src="preview.url" :alt="preview.name" class="w-full h-48 object-cover">
                                                        <div class="absolute top-2 right-2">
                                                            <div class="bg-green-500 text-white rounded-full p-1.5 shadow-lg">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-4 bg-gradient-to-br from-blue-50 to-white">
                                                        <label :for="'caption_' + index" class="block text-xs font-semibold text-gray-700 mb-2">
                                                            📝 Image Description
                                                        </label>
                                                        <input 
                                                            :id="'caption_' + index"
                                                            :name="'image_captions[]'"
                                                            type="text"
                                                            x-model="captions[index]"
                                                            class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            :placeholder="'Describe this image...'"
                                                        />
                                                        <p class="text-xs text-gray-500 mt-1 truncate" x-text="preview.name"></p>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <p class="text-sm text-gray-600 mt-2 flex items-center gap-2" x-show="files.length > 0">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-semibold" x-text="files.length"></span> image(s) selected - Add descriptions to help attendees understand each image
                                        </p>
                                    </div>
                                    <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                                </div>

                                <!-- Videos Upload -->
                                <div>
                                    <x-input-label for="videos" :value="__('Event Videos (Optional, Max 100MB each)')" class="text-gray-700 font-semibold mb-3" />
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
                                    <x-input-error :messages="$errors->get('videos.*')" class="mt-2" />
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
                                    <h3 class="text-2xl font-bold text-gray-800">Terms & Conditions</h3>
                                    <p class="text-sm text-gray-600">Please review and agree to the terms</p>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
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
                                            I confirm that all information provided is accurate and I understand my responsibilities as an event organizer.
                                        </label>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" id="cancellation_policy" name="cancellation_policy" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="cancellation_policy" class="text-sm text-gray-700">
                                            I acknowledge that I will provide a clear <span class="font-semibold text-blue-600">cancellation and refund policy</span> to all attendees.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                <span class="text-red-600">*</span> Required fields
                            </p>
                            <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Create Event
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
