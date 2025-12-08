<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="name" :value="__('Event Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category" :value="__('Category')" />
                                    <select id="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="category">
                                        <option value="">Select a category</option>
                                        <option value="conference" {{ old('category') == 'conference' ? 'selected' : '' }}>Conference</option>
                                        <option value="workshop" {{ old('category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                        <option value="concert" {{ old('category') == 'concert' ? 'selected' : '' }}>Concert</option>
                                        <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                        <option value="exhibition" {{ old('category') == 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                        <option value="networking" {{ old('category') == 'networking' ? 'selected' : '' }}>Networking</option>
                                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" rows="4" placeholder="Provide a detailed description of the event...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Date and Time -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Date and Time</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="date" :value="__('Start Date & Time')" />
                                    <x-text-input id="date" class="block mt-1 w-full" type="datetime-local" name="date" :value="old('date')" required />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="end_date" :value="__('End Date & Time')" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" :value="old('end_date')" />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Location and Venue -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Location and Venue</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="location" :value="__('Location')" />
                                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autocomplete="location" />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="venue_id" :value="__('Venue')" />
                                    <select id="venue_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="venue_id" required>
                                        <option value="">Select a venue</option>
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Capacity and Pricing -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Capacity and Pricing</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="capacity" :value="__('Capacity')" />
                                    <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" min="1" placeholder="Maximum number of attendees" />
                                    <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="price" :value="__('Price ($)')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" min="0" placeholder="0.00 for free events" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="event_type" :value="__('Event Type')" />
                                    <select id="event_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="event_type">
                                        <option value="">Select event type</option>
                                        <option value="public" {{ old('event_type') == 'public' ? 'selected' : '' }}>Public</option>
                                        <option value="private" {{ old('event_type') == 'private' ? 'selected' : '' }}>Private</option>
                                        <option value="vip" {{ old('event_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                                        <option value="corporate" {{ old('event_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('event_type')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Organizer Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Organizer Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="organizer_name" :value="__('Organizer Name')" />
                                    <x-text-input id="organizer_name" class="block mt-1 w-full" type="text" name="organizer_name" :value="old('organizer_name')" />
                                    <x-input-error :messages="$errors->get('organizer_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="organizer_email" :value="__('Organizer Email')" />
                                    <x-text-input id="organizer_email" class="block mt-1 w-full" type="email" name="organizer_email" :value="old('organizer_email')" />
                                    <x-input-error :messages="$errors->get('organizer_email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="organizer_phone" :value="__('Organizer Phone')" />
                                    <x-text-input id="organizer_phone" class="block mt-1 w-full" type="tel" name="organizer_phone" :value="old('organizer_phone')" />
                                    <x-input-error :messages="$errors->get('organizer_phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="contact_person" :value="__('Contact Person')" />
                                    <x-text-input id="contact_person" class="block mt-1 w-full" type="text" name="contact_person" :value="old('contact_person')" />
                                    <x-input-error :messages="$errors->get('contact_person')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Additional Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="language" :value="__('Language')" />
                                    <select id="language" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="language">
                                        <option value="">Select language</option>
                                        <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French</option>
                                        <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Spanish</option>
                                        <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>German</option>
                                        <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>Arabic</option>
                                        <option value="zh" {{ old('language') == 'zh' ? 'selected' : '' }}>Chinese</option>
                                        <option value="other" {{ old('language') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="website" :value="__('Website')" />
                                    <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://example.com" />
                                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="min_age" :value="__('Minimum Age')" />
                                    <x-text-input id="min_age" class="block mt-1 w-full" type="number" name="min_age" :value="old('min_age')" min="0" />
                                    <x-input-error :messages="$errors->get('min_age')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="max_age" :value="__('Maximum Age')" />
                                    <x-text-input id="max_age" class="block mt-1 w-full" type="number" name="max_age" :value="old('max_age')" min="0" />
                                    <x-input-error :messages="$errors->get('max_age')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Agenda and Requirements -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Agenda and Requirements</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="agenda" :value="__('Agenda')" />
                                    <textarea id="agenda" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="agenda" rows="4" placeholder="Outline the event schedule and activities...">{{ old('agenda') }}</textarea>
                                    <x-input-error :messages="$errors->get('agenda')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="requirements" :value="__('Requirements')" />
                                    <textarea id="requirements" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="requirements" rows="4" placeholder="Any special requirements or prerequisites...">{{ old('requirements') }}</textarea>
                                    <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Accessibility and Additional Info -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Accessibility and Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="accessibility_info" :value="__('Accessibility Information')" />
                                    <textarea id="accessibility_info" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="accessibility_info" rows="3" placeholder="Wheelchair access, parking, etc.">{{ old('accessibility_info') }}</textarea>
                                    <x-input-error :messages="$errors->get('accessibility_info')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="additional_info" :value="__('Additional Information')" />
                                    <textarea id="additional_info" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="additional_info" rows="3" placeholder="Any other relevant information...">{{ old('additional_info') }}</textarea>
                                    <x-input-error :messages="$errors->get('additional_info')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Settings</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center">
                                    <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="is_featured" class="ml-2 text-sm text-gray-900">Featured Event</label>
                                </div>

                                <div class="flex items-center">
                                    <input id="allow_registrations" type="checkbox" name="allow_registrations" value="1" {{ old('allow_registrations', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="allow_registrations" class="ml-2 text-sm text-gray-900">Allow Registrations</label>
                                </div>

                                <div>
                                    <x-input-label for="registration_deadline" :value="__('Registration Deadline')" />
                                    <x-text-input id="registration_deadline" class="block mt-1 w-full" type="datetime-local" name="registration_deadline" :value="old('registration_deadline')" />
                                    <x-input-error :messages="$errors->get('registration_deadline')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="mb-6">
                            <x-input-label for="tags" :value="__('Tags (comma-separated)')" />
                            <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" :value="old('tags')" placeholder="music, entertainment, networking" />
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-6">
                            <x-input-label for="image" :value="__('Event Image')" />
                            <input id="image" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="file" name="image" accept="image/*">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Upload an image for the event (optional)</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('events.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Event') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
