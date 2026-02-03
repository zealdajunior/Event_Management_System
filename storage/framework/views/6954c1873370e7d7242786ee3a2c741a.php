

<?php $__env->startSection('title', 'Event Calendar'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Event Calendar</h1>
                    <p class="text-gray-600">Discover events happening around you</p>
                </div>
                <div class="flex space-x-3">
                    <button type="button" id="calendar-filters-btn" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filters
                    </button>
                    <div class="flex rounded-md shadow-sm" role="group">
                        <a href="<?php echo e(route('calendar.index')); ?>" 
                           class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            Calendar
                        </a>
                        <a href="<?php echo e(route('calendar.map')); ?>" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                            Map View
                        </a>
                    </div>
                    <button type="button" id="export-calendar-btn" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">This Month</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Events</span>
                            <span class="text-sm font-medium text-gray-900" id="stats-total-events"><?php echo e($stats['total_events']); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Featured</span>
                            <span class="text-sm font-medium text-indigo-600" id="stats-featured-events"><?php echo e($stats['featured_events']); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Free Events</span>
                            <span class="text-sm font-medium text-green-600" id="stats-free-events"><?php echo e($stats['free_events']); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Revenue</span>
                            <span class="text-sm font-medium text-gray-900" id="stats-revenue">$<?php echo e(number_format($stats['total_revenue'], 2)); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <label for="calendar-search" class="block text-sm font-medium text-gray-700 mb-2">Search Events</label>
                    <div class="relative">
                        <input type="text" 
                               id="calendar-search" 
                               placeholder="Search events, venues, categories..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div id="search-results" class="hidden mt-4 max-h-64 overflow-y-auto">
                        <!-- Search results will be populated here -->
                    </div>
                </div>

                <!-- Calendar Navigation -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="space-y-4">
                        <h3 class="text-sm font-medium text-gray-700">Quick Navigation</h3>
                        <div class="space-y-2">
                            <button type="button" data-navigate="today" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md calendar-nav-btn">
                                Today
                            </button>
                            <button type="button" data-navigate="this-week" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md calendar-nav-btn">
                                This Week
                            </button>
                            <button type="button" data-navigate="next-week" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md calendar-nav-btn">
                                Next Week
                            </button>
                            <button type="button" data-navigate="this-month" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md calendar-nav-btn">
                                This Month
                            </button>
                            <button type="button" data-navigate="next-month" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md calendar-nav-btn">
                                Next Month
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Legend</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded mr-2"></div>
                            <span class="text-xs text-gray-600">Regular Events</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded mr-2"></div>
                            <span class="text-xs text-gray-600">Featured Events</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded mr-2"></div>
                            <span class="text-xs text-gray-600">Sold Out</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded mr-2"></div>
                            <span class="text-xs text-gray-600">Free Events</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow">
                    <!-- Calendar Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900" id="calendar-title">Loading...</h2>
                                <p class="text-sm text-gray-600" id="calendar-subtitle">View events by date</p>
                            </div>
                            <div class="flex space-x-2">
                                <div class="btn-group">
                                    <button type="button" data-view="dayGridMonth" 
                                            class="px-3 py-1 text-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-l-md calendar-view-btn active">
                                        Month
                                    </button>
                                    <button type="button" data-view="timeGridWeek" 
                                            class="px-3 py-1 text-sm border-t border-b border-gray-300 bg-white text-gray-700 hover:bg-gray-50 calendar-view-btn">
                                        Week
                                    </button>
                                    <button type="button" data-view="timeGridDay" 
                                            class="px-3 py-1 text-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-r-md calendar-view-btn">
                                        Day
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Body -->
                    <div class="p-6">
                        <div id="calendar" class="min-h-[600px]">
                            <!-- FullCalendar will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Modal -->
<div id="filters-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Filter Events</h3>
                <button type="button" id="close-filters-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="calendar-filters-form" class="space-y-4">
                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="filter-category" name="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                        <option value="">All Categories</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filters['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <!-- Venues -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                    <select id="filter-venue" name="venue_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                        <option value="">All Venues</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filters['venues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($venue->id); ?>"><?php echo e($venue->name); ?> - <?php echo e($venue->city); ?>, <?php echo e($venue->state); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" id="filter-location" name="location" placeholder="Enter city, state, or country" 
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                </div>

                <!-- Price Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                        <input type="number" id="filter-price-min" name="price_min" min="0" step="0.01" placeholder="0.00" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                        <input type="number" id="filter-price-max" name="price_max" min="0" step="0.01" placeholder="1000.00" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" id="filter-start-date" name="start_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" id="filter-end-date" name="end_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <!-- Location-based filters -->
                <div id="location-filters" class="hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Location-based Filters</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <input type="hidden" id="filter-latitude" name="latitude">
                        <input type="hidden" id="filter-longitude" name="longitude">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Radius (km)</label>
                            <select id="filter-radius" name="radius" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="5">5 km</option>
                                <option value="10">10 km</option>
                                <option value="25" selected>25 km</option>
                                <option value="50">50 km</option>
                                <option value="100">100 km</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <button type="button" id="use-my-location-btn" 
                                    class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Use My Location
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="clear-filters-btn" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear All
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="export-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Export Calendar</h3>
                <button type="button" id="close-export-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="export-calendar-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                    <select id="export-format" name="format" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                        <option value="ics">iCalendar (.ics)</option>
                        <option value="csv">CSV Spreadsheet</option>
                        <option value="json">JSON Data</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" id="export-start-date" name="start_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" id="export-end-date" name="end_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="cancel-export-btn" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div id="event-detail-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div id="event-detail-content">
            <!-- Event details will be loaded here -->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar configuration
    const calendarConfig = {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: {
            url: '<?php echo e(route("calendar.events")); ?>',
            method: 'GET',
            extraParams: function() {
                return getCurrentFilters();
            }
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            showEventDetail(info.event);
        },
        dateClick: function(info) {
            loadEventsForDate(info.dateStr);
        },
        loading: function(isLoading) {
            if (isLoading) {
                showLoadingSpinner();
            } else {
                hideLoadingSpinner();
            }
        },
        eventDidMount: function(info) {
            // Add tooltips to events
            info.el.title = `${info.event.title}\n${info.event.extendedProps.location}\n${info.event.extendedProps.formatted_price}`;
        },
        height: 600,
        aspectRatio: 1.35,
        nowIndicator: true,
        navLinks: true,
        weekNumbers: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        moreLinkClick: 'popover'
    };

    // Initialize calendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, calendarConfig);
    calendar.render();

    // Update calendar title and subtitle
    calendar.on('datesSet', function() {
        updateCalendarInfo();
        updateStats();
    });

    // View change buttons
    document.querySelectorAll('.calendar-view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            calendar.changeView(view);
            
            // Update active button
            document.querySelectorAll('.calendar-view-btn').forEach(b => b.classList.remove('active', 'bg-indigo-600', 'text-white'));
            this.classList.add('active', 'bg-indigo-600', 'text-white');
        });
    });

    // Navigation buttons
    document.querySelectorAll('.calendar-nav-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.navigate;
            navigateCalendar(action);
        });
    });

    // Search functionality
    let searchTimeout;
    document.getElementById('calendar-search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => searchEvents(query), 300);
        } else {
            hideSearchResults();
        }
    });

    // Filters modal
    document.getElementById('calendar-filters-btn').addEventListener('click', () => {
        document.getElementById('filters-modal').classList.remove('hidden');
    });

    document.getElementById('close-filters-modal').addEventListener('click', () => {
        document.getElementById('filters-modal').classList.add('hidden');
    });

    document.getElementById('calendar-filters-form').addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
        document.getElementById('filters-modal').classList.add('hidden');
    });

    document.getElementById('clear-filters-btn').addEventListener('click', () => {
        clearFilters();
    });

    // Export modal
    document.getElementById('export-calendar-btn').addEventListener('click', () => {
        setupExportModal();
        document.getElementById('export-modal').classList.remove('hidden');
    });

    document.getElementById('close-export-modal').addEventListener('click', () => {
        document.getElementById('export-modal').classList.add('hidden');
    });

    document.getElementById('cancel-export-btn').addEventListener('click', () => {
        document.getElementById('export-modal').classList.add('hidden');
    });

    document.getElementById('export-calendar-form').addEventListener('submit', function(e) {
        e.preventDefault();
        exportCalendar();
    });

    // Location-based filtering
    document.getElementById('use-my-location-btn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('filter-latitude').value = position.coords.latitude;
                document.getElementById('filter-longitude').value = position.coords.longitude;
                document.getElementById('location-filters').classList.remove('hidden');
                
                // Update button text
                document.getElementById('use-my-location-btn').innerHTML = `
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Location Set
                `;
            }, function() {
                alert('Unable to retrieve your location. Please enter a location manually.');
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    // Utility functions
    function getCurrentFilters() {
        const form = document.getElementById('calendar-filters-form');
        if (!form) return {};
        
        const formData = new FormData(form);
        const filters = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) filters[key] = value;
        }
        
        return filters;
    }

    function applyFilters() {
        calendar.refetchEvents();
        updateStats();
    }

    function clearFilters() {
        document.getElementById('calendar-filters-form').reset();
        document.getElementById('location-filters').classList.add('hidden');
        document.getElementById('use-my-location-btn').innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Use My Location
        `;
        applyFilters();
    }

    function navigateCalendar(action) {
        const today = new Date();
        
        switch (action) {
            case 'today':
                calendar.today();
                break;
            case 'this-week':
                calendar.gotoDate(today);
                calendar.changeView('timeGridWeek');
                break;
            case 'next-week':
                const nextWeek = new Date(today);
                nextWeek.setDate(today.getDate() + 7);
                calendar.gotoDate(nextWeek);
                calendar.changeView('timeGridWeek');
                break;
            case 'this-month':
                calendar.gotoDate(today);
                calendar.changeView('dayGridMonth');
                break;
            case 'next-month':
                const nextMonth = new Date(today);
                nextMonth.setMonth(today.getMonth() + 1);
                calendar.gotoDate(nextMonth);
                calendar.changeView('dayGridMonth');
                break;
        }
    }

    function searchEvents(query) {
        fetch(`<?php echo e(route('calendar.search')); ?>?query=${encodeURIComponent(query)}&type=events`)
            .then(response => response.json())
            .then(data => {
                showSearchResults(data.results, query);
            })
            .catch(error => {
                console.error('Search error:', error);
            });
    }

    function showSearchResults(results, query) {
        const container = document.getElementById('search-results');
        
        if (results.length === 0) {
            container.innerHTML = `<p class="text-sm text-gray-500">No events found for "${query}"</p>`;
        } else {
            container.innerHTML = results.map(event => `
                <div class="border-b border-gray-100 last:border-b-0 py-2">
                    <a href="${event.url}" class="block hover:bg-gray-50 rounded p-2">
                        <h4 class="text-sm font-medium text-gray-900">${event.name}</h4>
                        <p class="text-xs text-gray-600">${event.date} • ${event.venue}</p>
                        <p class="text-xs text-indigo-600">${event.price}</p>
                    </a>
                </div>
            `).join('');
        }
        
        container.classList.remove('hidden');
    }

    function hideSearchResults() {
        document.getElementById('search-results').classList.add('hidden');
    }

    function loadEventsForDate(dateStr) {
        fetch(`<?php echo e(route('calendar.events-for-date')); ?>?date=${dateStr}`)
            .then(response => response.json())
            .then(data => {
                showEventsForDate(data, dateStr);
            })
            .catch(error => {
                console.error('Error loading events for date:', error);
            });
    }

    function showEventsForDate(data, date) {
        const formattedDate = new Date(date).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        let content = `
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Events on ${formattedDate}</h3>
                <button type="button" id="close-event-detail" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;

        if (data.events.length === 0) {
            content += '<p class="text-gray-500">No events scheduled for this date.</p>';
        } else {
            content += '<div class="space-y-4">';
            data.events.forEach(event => {
                content += `
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">${event.name}</h4>
                                <p class="text-sm text-gray-600 mt-1">${event.formatted_time} at ${event.venue}</p>
                                <p class="text-sm text-indigo-600 mt-1">${event.price}</p>
                                ${event.category ? `<span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded mt-2">${event.category}</span>` : ''}
                            </div>
                            ${event.image ? `<img src="${event.image}" alt="${event.name}" class="w-16 h-16 object-cover rounded ml-4">` : ''}
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-sm ${event.is_sold_out ? 'text-red-600' : 'text-green-600'}">
                                ${event.is_sold_out ? 'Sold Out' : `${event.available_tickets} tickets available`}
                            </span>
                            <a href="${event.url}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Details
                            </a>
                        </div>
                    </div>
                `;
            });
            content += '</div>';
        }

        document.getElementById('event-detail-content').innerHTML = content;
        document.getElementById('event-detail-modal').classList.remove('hidden');

        document.getElementById('close-event-detail').addEventListener('click', () => {
            document.getElementById('event-detail-modal').classList.add('hidden');
        });
    }

    function showEventDetail(event) {
        const props = event.extendedProps;
        
        let content = `
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">${event.title}</h3>
                <button type="button" id="close-event-detail" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                ${props.image ? `<img src="${props.image}" alt="${event.title}" class="w-full h-48 object-cover rounded-lg">` : ''}
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Date & Time</p>
                        <p class="text-sm text-gray-600">${new Date(event.start).toLocaleString()}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Price</p>
                        <p class="text-sm text-gray-600">${props.formatted_price}</p>
                    </div>
                </div>
                
                ${props.location ? `
                    <div>
                        <p class="text-sm font-medium text-gray-700">Location</p>
                        <p class="text-sm text-gray-600">${props.location}</p>
                    </div>
                ` : ''}
                
                ${props.description ? `
                    <div>
                        <p class="text-sm font-medium text-gray-700">Description</p>
                        <p class="text-sm text-gray-600">${props.description}</p>
                    </div>
                ` : ''}
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Availability</p>
                        <p class="text-sm ${props.is_sold_out ? 'text-red-600' : 'text-green-600'}">
                            ${props.is_sold_out ? 'Sold Out' : `${props.available_tickets} tickets available`}
                        </p>
                    </div>
                    ${props.category ? `
                        <div>
                            <p class="text-sm font-medium text-gray-700">Category</p>
                            <p class="text-sm text-gray-600">${props.category}</p>
                        </div>
                    ` : ''}
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="${event.url}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Details
                    </a>
                    ${!props.is_sold_out ? `
                        <a href="${event.url}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Book Now
                        </a>
                    ` : ''}
                </div>
            </div>
        `;

        document.getElementById('event-detail-content').innerHTML = content;
        document.getElementById('event-detail-modal').classList.remove('hidden');

        document.getElementById('close-event-detail').addEventListener('click', () => {
            document.getElementById('event-detail-modal').classList.add('hidden');
        });
    }

    function updateCalendarInfo() {
        const view = calendar.view;
        document.getElementById('calendar-title').textContent = view.title;
        
        let subtitle = '';
        switch (view.type) {
            case 'dayGridMonth':
                subtitle = 'Monthly view of events';
                break;
            case 'timeGridWeek':
                subtitle = 'Weekly schedule view';
                break;
            case 'timeGridDay':
                subtitle = 'Daily schedule view';
                break;
        }
        
        document.getElementById('calendar-subtitle').textContent = subtitle;
    }

    function updateStats() {
        const view = calendar.view;
        const start = view.activeStart.toISOString().split('T')[0];
        const end = view.activeEnd.toISOString().split('T')[0];
        
        fetch(`<?php echo e(route('calendar.stats')); ?>?start=${start}&end=${end}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('stats-total-events').textContent = data.total_events;
                document.getElementById('stats-featured-events').textContent = data.featured_events;
                document.getElementById('stats-free-events').textContent = data.free_events;
                document.getElementById('stats-revenue').textContent = `$${data.total_revenue.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            })
            .catch(error => {
                console.error('Error updating stats:', error);
            });
    }

    function setupExportModal() {
        const view = calendar.view;
        const startDate = view.activeStart.toISOString().split('T')[0];
        const endDate = view.activeEnd.toISOString().split('T')[0];
        
        document.getElementById('export-start-date').value = startDate;
        document.getElementById('export-end-date').value = endDate;
    }

    function exportCalendar() {
        const form = document.getElementById('export-calendar-form');
        const formData = new FormData(form);
        
        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        // Add current filters
        const filters = getCurrentFilters();
        for (let [key, value] of Object.entries(filters)) {
            params.append(key, value);
        }
        
        window.location.href = `<?php echo e(route('calendar.export')); ?>?${params.toString()}`;
        document.getElementById('export-modal').classList.add('hidden');
    }

    function showLoadingSpinner() {
        // Add loading indicator
    }

    function hideLoadingSpinner() {
        // Remove loading indicator
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/calendar/index.blade.php ENDPATH**/ ?>