<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-8">
        <!-- Header -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white">Request New Event</h1>
                        <p class="text-blue-100 text-sm mt-1">Submit your event proposal for admin review</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('event-requests.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Title -->
                            <div class="md:col-span-2">
                                <label for="event_title" class="block text-sm font-bold text-gray-700 mb-2">Event Title *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <input id="event_title" name="event_title" type="text" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="Enter your event title" 
                                           value="{{ old('event_title') }}" required />
                                </div>
                                <x-input-error :messages="$errors->get('event_title')" class="mt-2" />
                            </div>

                            <!-- Event Description -->
                            <div class="md:col-span-2">
                                <label for="event_description" class="block text-sm font-bold text-gray-700 mb-2">Event Description *</label>
                                <p class="text-xs text-gray-600 mb-3">Use the editor below to format your event description. You can add headings, lists, bold text, and more.</p>
                                
                                <input id="event_description_input" type="hidden" name="event_description" value="{{ old('event_description') }}" required>
                                <trix-editor 
                                    input="event_description_input" 
                                    class="trix-content border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg min-h-[300px] bg-white"
                                    placeholder="Describe your event in detail. Include:
• What will happen at the event
• Who should attend
• What attendees will learn or experience
• Any special guests or speakers
• Schedule highlights
• What to bring or prepare
• Why this event is important"></trix-editor>
                                
                                <x-input-error :messages="$errors->get('event_description')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">Start Date & Time *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input id="start_date" name="start_date" type="datetime-local" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           value="{{ old('start_date') }}" required />
                                </div>
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">End Date & Time *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input id="end_date" name="end_date" type="datetime-local" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           value="{{ old('end_date') }}" required />
                                </div>
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Venue -->
                            <div class="md:col-span-2">
                                <label for="venue" class="block text-sm font-bold text-gray-700 mb-2">Venue *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input id="venue" name="venue" type="text" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="Enter venue location" 
                                           value="{{ old('venue') }}" required />
                                </div>
                                <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                            </div>

                            <!-- Expected Attendance -->
                            <div>
                                <label for="expected_attendance" class="block text-sm font-bold text-gray-700 mb-2">Expected Attendees</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <input id="expected_attendance" name="expected_attendance" type="number" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="Estimated number" 
                                           value="{{ old('expected_attendance') }}" min="1" />
                                </div>
                                <x-input-error :messages="$errors->get('expected_attendance')" class="mt-2" />
                            </div>

                            <!-- Event Category -->
                            <div>
                                <label for="event_category" class="block text-sm font-bold text-gray-700 mb-2">Event Category</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <select id="event_category" name="event_category" 
                                            class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300">
                                        <option value="">Select Category</option>
                                        <option value="conference" {{ old('event_category') == 'conference' ? 'selected' : '' }}>Conference</option>
                                        <option value="workshop" {{ old('event_category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                        <option value="seminar" {{ old('event_category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                        <option value="concert" {{ old('event_category') == 'concert' ? 'selected' : '' }}>Concert</option>
                                        <option value="sports" {{ old('event_category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                        <option value="exhibition" {{ old('event_category') == 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                        <option value="other" {{ old('event_category') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('event_category')" class="mt-2" />
                            </div>

                            <!-- Target Audience -->
                            <div class="md:col-span-2">
                                <label for="target_audience" class="block text-sm font-bold text-gray-700 mb-2">Target Audience</label>
                                <textarea id="target_audience" name="target_audience" rows="2" 
                                          class="block w-full px-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                          placeholder="e.g., Students, Professionals, General Public">{{ old('target_audience') }}</textarea>
                                <x-input-error :messages="$errors->get('target_audience')" class="mt-2" />
                            </div>

                            <!-- Budget Estimate -->
                            <div>
                                <label for="budget_estimate" class="block text-sm font-bold text-gray-700 mb-2">Estimated Budget ($)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <input id="budget_estimate" name="budget_estimate" type="number" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="0.00" 
                                           value="{{ old('budget_estimate') }}" min="0" step="0.01" />
                                </div>
                                <x-input-error :messages="$errors->get('budget_estimate')" class="mt-2" />
                            </div>

                            <!-- Ticket Pricing -->
                            <div>
                                <label for="ticket_pricing" class="block text-sm font-bold text-gray-700 mb-2">Ticket Pricing</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <select id="ticket_pricing" name="ticket_pricing" 
                                            class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300">
                                        <option value="">Select Pricing</option>
                                        <option value="free" {{ old('ticket_pricing') == 'free' ? 'selected' : '' }}>Free</option>
                                        <option value="paid" {{ old('ticket_pricing') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="donation" {{ old('ticket_pricing') == 'donation' ? 'selected' : '' }}>Donation Based</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('ticket_pricing')" class="mt-2" />
                            </div>

                            <!-- Special Requirements -->
                            <div class="md:col-span-2">
                                <label for="special_requirements" class="block text-sm font-bold text-gray-700 mb-2">Special Requirements</label>
                                <textarea id="special_requirements" name="special_requirements" rows="3" 
                                          class="block w-full px-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                          placeholder="e.g., Sound system, Projector, Catering, etc.">{{ old('special_requirements') }}</textarea>
                                <x-input-error :messages="$errors->get('special_requirements')" class="mt-2" />
                            </div>

                            <!-- Marketing Plan -->
                            <div class="md:col-span-2">
                                <label for="marketing_plan" class="block text-sm font-bold text-gray-700 mb-2">Marketing & Promotion Plan</label>
                                <textarea id="marketing_plan" name="marketing_plan" rows="3" 
                                          class="block w-full px-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                          placeholder="How do you plan to promote this event?">{{ old('marketing_plan') }}</textarea>
                                <x-input-error :messages="$errors->get('marketing_plan')" class="mt-2" />
                            </div>

                            <!-- Contact Information -->
                            <div>
                                <label for="contact_phone" class="block text-sm font-bold text-gray-700 mb-2">Contact Phone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input id="contact_phone" name="contact_phone" type="tel" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="+1 (555) 123-4567" 
                                           value="{{ old('contact_phone') }}" />
                                </div>
                                <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                            </div>

                            <div>
                                <label for="contact_email" class="block text-sm font-bold text-gray-700 mb-2">Contact Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input id="contact_email" name="contact_email" type="email" 
                                           class="block w-full pl-10 pr-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                           placeholder="your.email@example.com" 
                                           value="{{ old('contact_email') }}" />
                                </div>
                                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                            </div>

                            <!-- Additional Notes -->
                            <div class="md:col-span-2">
                                <label for="additional_notes" class="block text-sm font-bold text-gray-700 mb-2">Additional Notes</label>
                                <textarea id="additional_notes" name="additional_notes" rows="3" 
                                          class="block w-full px-4 py-3 bg-blue-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300" 
                                          placeholder="Any additional information you'd like to provide">{{ old('additional_notes') }}</textarea>
                                <x-input-error :messages="$errors->get('additional_notes')" class="mt-2" />
                            </div>

                            <!-- Media Upload Section -->
                            <div class="md:col-span-2 mt-6">
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200">
                                    <h4 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Event Media
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <!-- Images Upload -->
                                        <div>
                                            <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Event Images (Max 10MB each)</label>
                                            <div x-data="{ files: [] }" class="space-y-2">
                                                <div class="relative border-2 border-dashed border-purple-300 rounded-lg p-6 text-center hover:border-purple-500 transition-all duration-300 bg-white/50">
                                                    <input type="file" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                           @change="files = Array.from($event.target.files)" />
                                                    <div class="pointer-events-none">
                                                        <svg class="mx-auto h-10 w-10 text-purple-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            <span class="font-semibold text-purple-600">Click to upload images</span> or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP up to 10MB each</p>
                                                    </div>
                                                </div>
                                                <div x-show="files.length > 0" class="bg-purple-50 rounded-lg p-3 border border-purple-200">
                                                    <p class="text-sm font-semibold text-gray-700 mb-1">Selected Files:</p>
                                                    <ul class="space-y-1">
                                                        <template x-for="file in files" :key="file.name">
                                                            <li class="text-xs text-gray-600 flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span x-text="file.name"></span>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>
                                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                                        </div>

                                        <!-- Videos Upload -->
                                        <div>
                                            <label for="videos" class="block text-sm font-bold text-gray-700 mb-2">Event Videos (Max 100MB each)</label>
                                            <div x-data="{ videos: [] }" class="space-y-2">
                                                <div class="relative border-2 border-dashed border-pink-300 rounded-lg p-6 text-center hover:border-pink-500 transition-all duration-300 bg-white/50">
                                                    <input type="file" id="videos" name="videos[]" multiple accept="video/mp4,video/mov,video/avi,video/wmv,video/flv" 
                                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                           @change="videos = Array.from($event.target.files)" />
                                                    <div class="pointer-events-none">
                                                        <svg class="mx-auto h-10 w-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            <span class="font-semibold text-pink-600">Click to upload videos</span> or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1">MP4, MOV, AVI, WMV, FLV up to 100MB each</p>
                                                    </div>
                                                </div>
                                                <div x-show="videos.length > 0" class="bg-pink-50 rounded-lg p-3 border border-pink-200">
                                                    <p class="text-sm font-semibold text-gray-700 mb-1">Selected Videos:</p>
                                                    <ul class="space-y-1">
                                                        <template x-for="video in videos" :key="video.name">
                                                            <li class="text-xs text-gray-600 flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span x-text="video.name"></span>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>
                                            <x-input-error :messages="$errors->get('videos.*')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                            <a href="@dashboardRoute" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Submit Event Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
</x-app-layout>
