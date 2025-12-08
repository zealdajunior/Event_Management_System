<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Request New Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('event-requests.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Title -->
                            <div class="md:col-span-2">
                                <x-input-label for="event_title" :value="__('Event Title')" />
                                <x-text-input id="event_title" name="event_title" type="text" class="mt-1 block w-full" :value="old('event_title')" required />
                                <x-input-error :messages="$errors->get('event_title')" class="mt-2" />
                            </div>

                            <!-- Event Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="event_description" :value="__('Event Description')" />
                                <textarea id="event_description" name="event_description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('event_description') }}</textarea>
                                <x-input-error :messages="$errors->get('event_description')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date & Time')" />
                                <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <x-input-label for="end_date" :value="__('End Date & Time')" />
                                <x-text-input id="end_date" name="end_date" type="datetime-local" class="mt-1 block w-full" :value="old('end_date')" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Venue -->
                            <div class="md:col-span-2">
                                <x-input-label for="venue" :value="__('Venue')" />
                                <x-text-input id="venue" name="venue" type="text" class="mt-1 block w-full" :value="old('venue')" required />
                                <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                            </div>

                            <!-- Expected Attendance -->
                            <div>
                                <x-input-label for="expected_attendance" :value="__('Expected Number of Attendees')" />
                                <x-text-input id="expected_attendance" name="expected_attendance" type="number" class="mt-1 block w-full" :value="old('expected_attendance')" min="1" />
                                <x-input-error :messages="$errors->get('expected_attendance')" class="mt-2" />
                            </div>

                            <!-- Event Category -->
                            <div>
                                <x-input-label for="event_category" :value="__('Event Category')" />
                                <select id="event_category" name="event_category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Select Category</option>
                                    <option value="conference" {{ old('event_category') == 'conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="workshop" {{ old('event_category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="seminar" {{ old('event_category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="concert" {{ old('event_category') == 'concert' ? 'selected' : '' }}>Concert</option>
                                    <option value="sports" {{ old('event_category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                    <option value="exhibition" {{ old('event_category') == 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                    <option value="other" {{ old('event_category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('event_category')" class="mt-2" />
                            </div>

                            <!-- Target Audience -->
                            <div class="md:col-span-2">
                                <x-input-label for="target_audience" :value="__('Target Audience')" />
                                <textarea id="target_audience" name="target_audience" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="e.g., Students, Professionals, General Public">{{ old('target_audience') }}</textarea>
                                <x-input-error :messages="$errors->get('target_audience')" class="mt-2" />
                            </div>

                            <!-- Budget Estimate -->
                            <div>
                                <x-input-label for="budget_estimate" :value="__('Estimated Budget ($)')" />
                                <x-text-input id="budget_estimate" name="budget_estimate" type="number" class="mt-1 block w-full" :value="old('budget_estimate')" min="0" step="0.01" />
                                <x-input-error :messages="$errors->get('budget_estimate')" class="mt-2" />
                            </div>

                            <!-- Ticket Pricing -->
                            <div>
                                <x-input-label for="ticket_pricing" :value="__('Ticket Pricing Strategy')" />
                                <select id="ticket_pricing" name="ticket_pricing" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Select Pricing</option>
                                    <option value="free" {{ old('ticket_pricing') == 'free' ? 'selected' : '' }}>Free</option>
                                    <option value="paid" {{ old('ticket_pricing') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="donation" {{ old('ticket_pricing') == 'donation' ? 'selected' : '' }}>Donation Based</option>
                                </select>
                                <x-input-error :messages="$errors->get('ticket_pricing')" class="mt-2" />
                            </div>

                            <!-- Special Requirements -->
                            <div class="md:col-span-2">
                                <x-input-label for="special_requirements" :value="__('Special Requirements or Equipment Needed')" />
                                <textarea id="special_requirements" name="special_requirements" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="e.g., Sound system, Projector, Catering, etc.">{{ old('special_requirements') }}</textarea>
                                <x-input-error :messages="$errors->get('special_requirements')" class="mt-2" />
                            </div>

                            <!-- Marketing Plan -->
                            <div class="md:col-span-2">
                                <x-input-label for="marketing_plan" :value="__('Marketing and Promotion Plan')" />
                                <textarea id="marketing_plan" name="marketing_plan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="How do you plan to promote this event?">{{ old('marketing_plan') }}</textarea>
                                <x-input-error :messages="$errors->get('marketing_plan')" class="mt-2" />
                            </div>

                            <!-- Contact Information -->
                            <div>
                                <x-input-label for="contact_phone" :value="__('Contact Phone Number')" />
                                <x-text-input id="contact_phone" name="contact_phone" type="tel" class="mt-1 block w-full" :value="old('contact_phone')" />
                                <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="contact_email" :value="__('Contact Email')" />
                                <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full" :value="old('contact_email')" />
                                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                            </div>

                            <!-- Additional Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="additional_notes" :value="__('Additional Notes or Comments')" />
                                <textarea id="additional_notes" name="additional_notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Any additional information you'd like to provide">{{ old('additional_notes') }}</textarea>
                                <x-input-error :messages="$errors->get('additional_notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Submit Event Request') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
