

<?php $__env->startSection('title', 'Event Map'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Event Map</h1>
                    <p class="text-gray-600">Explore events by location</p>
                </div>
                <div class="flex space-x-3">
                    <button type="button" id="map-filters-btn" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filters
                    </button>
                    <div class="flex rounded-md shadow-sm" role="group">
                        <a href="<?php echo e(route('calendar.index')); ?>" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                            Calendar
                        </a>
                        <a href="<?php echo e(route('calendar.map')); ?>" 
                           class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            Map View
                        </a>
                    </div>
                    <button type="button" id="find-nearby-btn" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Find Nearby
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-80 bg-white shadow-lg overflow-y-auto">
            <!-- Search -->
            <div class="p-4 border-b">
                <div class="relative">
                    <input type="text" 
                           id="map-search" 
                           placeholder="Search events or locations..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Map Controls -->
            <div class="p-4 border-b">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Show Clusters</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="show-clusters" checked class="sr-only">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Radius</span>
                        <select id="search-radius" class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="5">5 km</option>
                            <option value="10">10 km</option>
                            <option value="25" selected>25 km</option>
                            <option value="50">50 km</option>
                            <option value="100">100 km</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Event List -->
            <div id="event-list" class="flex-1">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-medium text-gray-900">Events (<span id="event-count">0</span>)</h3>
                        <div class="flex space-x-1">
                            <button type="button" id="list-view-btn" class="p-1 text-gray-400 hover:text-gray-600 focus:outline-none active">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </button>
                            <button type="button" id="grid-view-btn" class="p-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="events-container" class="space-y-4">
                        <!-- Events will be loaded here -->
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Events will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Locations -->
            <div class="p-4 border-t bg-gray-50">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Popular Locations</h4>
                <div id="popular-locations" class="space-y-2">
                    <!-- Popular locations will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="flex-1 relative">
            <div id="map" class="w-full h-full">
                <!-- Map will be initialized here -->
            </div>
            
            <!-- Map Loading Overlay -->
            <div id="map-loading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center" style="display: none;">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-600">Loading map...</p>
                </div>
            </div>

            <!-- Map Controls -->
            <div class="absolute top-4 right-4 space-y-2">
                <button type="button" id="zoom-to-fit-btn" 
                        class="block w-10 h-10 bg-white rounded-md shadow-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                        title="Zoom to fit all events">
                    <svg class="w-5 h-5 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                <button type="button" id="center-user-location-btn" 
                        class="block w-10 h-10 bg-white rounded-md shadow-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                        title="Center on your location">
                    <svg class="w-5 h-5 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>

                <div class="bg-white rounded-md shadow-md border border-gray-300 p-2">
                    <label for="map-layer-select" class="block text-xs font-medium text-gray-700 mb-1">Map Layer</label>
                    <select id="map-layer-select" class="block w-full text-xs border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="roadmap">Roadmap</option>
                        <option value="satellite">Satellite</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="terrain">Terrain</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Modal -->
<div id="map-filters-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Filter Events</h3>
                <button type="button" id="close-map-filters-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="map-filters-form" class="space-y-4">
                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="map-filter-category" name="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                        <option value="">All Categories</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filters['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" id="map-filter-location" name="location" placeholder="Enter city, state, or country" 
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                </div>

                <!-- Price Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                        <input type="number" id="map-filter-price-min" name="price_min" min="0" step="0.01" placeholder="0.00" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                        <input type="number" id="map-filter-price-max" name="price_max" min="0" step="0.01" placeholder="1000.00" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" id="map-filter-start-date" name="start_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" id="map-filter-end-date" name="end_date" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="clear-map-filters-btn" 
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

<!-- Event Detail Popup -->
<div id="event-popup" class="hidden absolute bg-white rounded-lg shadow-lg border border-gray-200 p-4 max-w-sm z-40">
    <div id="event-popup-content">
        <!-- Event details will be loaded here -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Include Leaflet.js for maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Map configuration
    const mapCenter = <?php echo json_encode($mapCenter, 15, 512) ?>;
    let map;
    let markers = [];
    let markerClusterGroup;
    let userLocationMarker;
    let currentFilters = {};

    // Initialize map
    function initializeMap() {
        map = L.map('map').setView([mapCenter.latitude, mapCenter.longitude], mapCenter.zoom);

        // Default tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        // Initialize marker cluster group
        markerClusterGroup = L.markerClusterGroup({
            chunkedLoading: true,
            maxClusterRadius: 50,
            iconCreateFunction: function(cluster) {
                const count = cluster.getChildCount();
                let className = 'marker-cluster marker-cluster-small';
                
                if (count > 10) {
                    className = 'marker-cluster marker-cluster-medium';
                }
                if (count > 100) {
                    className = 'marker-cluster marker-cluster-large';
                }

                return new L.DivIcon({ 
                    html: `<div><span>${count}</span></div>`, 
                    className: className, 
                    iconSize: new L.Point(40, 40) 
                });
            }
        });

        map.addLayer(markerClusterGroup);

        // Load initial markers
        loadMapMarkers();
        loadPopularLocations();

        // Map event listeners
        map.on('moveend', function() {
            if (document.getElementById('show-clusters').checked) {
                updateVisibleMarkers();
            }
        });
    }

    // Load map markers
    function loadMapMarkers(filters = {}) {
        showMapLoading();
        
        const params = new URLSearchParams(filters);
        
        fetch(`<?php echo e(route('calendar.map-markers')); ?>?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                clearMarkers();
                addMarkers(data);
                updateEventList(data);
                hideMapLoading();
            })
            .catch(error => {
                console.error('Error loading map markers:', error);
                hideMapLoading();
            });
    }

    // Add markers to map
    function addMarkers(markersData) {
        markers = [];
        
        markersData.forEach(markerData => {
            const marker = createEventMarker(markerData);
            markers.push(marker);
            markerClusterGroup.addLayer(marker);
        });

        // Fit map to markers if we have any
        if (markers.length > 0) {
            // Don't auto-fit to avoid jarring movements
        }
    }

    // Create individual event marker
    function createEventMarker(markerData) {
        const { latitude, longitude, venue, events, event_count, color } = markerData;

        // Create custom icon based on event properties
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div class="marker-pin" style="background-color: ${color};">
                     <span class="marker-count">${event_count}</span>
                   </div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });

        const marker = L.marker([latitude, longitude], { icon })
            .bindPopup(createMarkerPopup(venue, events))
            .on('click', function() {
                showEventDetails(markerData);
            });

        return marker;
    }

    // Create marker popup content
    function createMarkerPopup(venue, events) {
        let popupContent = `
            <div class="p-2">
                <h3 class="font-semibold text-lg">${venue.name}</h3>
                <p class="text-sm text-gray-600 mb-2">${venue.address}</p>
                <p class="text-sm font-medium">Events (${events.length}):</p>
                <div class="max-h-40 overflow-y-auto space-y-2 mt-2">
        `;

        events.slice(0, 3).forEach(event => {
            popupContent += `
                <div class="border-b border-gray-100 last:border-b-0 pb-2">
                    <p class="text-sm font-medium">${event.name}</p>
                    <p class="text-xs text-gray-500">${event.formatted_datetime}</p>
                    <p class="text-xs text-indigo-600">${event.price}</p>
                </div>
            `;
        });

        if (events.length > 3) {
            popupContent += `<p class="text-xs text-gray-500 mt-2">+${events.length - 3} more events</p>`;
        }

        popupContent += `
                </div>
                <div class="mt-2 pt-2 border-t border-gray-100">
                    <button onclick="showVenueDetails(${venue.id})" class="text-xs text-indigo-600 hover:text-indigo-800">View All Events</button>
                </div>
            </div>
        `;

        return popupContent;
    }

    // Clear all markers
    function clearMarkers() {
        markerClusterGroup.clearLayers();
        markers = [];
    }

    // Update event list in sidebar
    function updateEventList(markersData) {
        const container = document.getElementById('events-container');
        const eventCount = document.getElementById('event-count');
        
        let allEvents = [];
        markersData.forEach(marker => {
            allEvents = allEvents.concat(marker.events.map(event => ({
                ...event,
                venue: marker.venue
            })));
        });

        eventCount.textContent = allEvents.length;

        if (allEvents.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No events found</p>
                </div>
            `;
            return;
        }

        // Sort events by date
        allEvents.sort((a, b) => new Date(a.date) - new Date(b.date));

        const isGridView = document.getElementById('grid-view-btn').classList.contains('active');

        let eventsHtml = '';
        allEvents.forEach(event => {
            if (isGridView) {
                eventsHtml += createEventGridItem(event);
            } else {
                eventsHtml += createEventListItem(event);
            }
        });

        container.innerHTML = eventsHtml;
    }

    // Create event list item
    function createEventListItem(event) {
        return `
            <div class="border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer" onclick="focusEventOnMap('${event.venue.id}')">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900">${event.name}</h4>
                        <p class="text-xs text-gray-600 mt-1">${event.formatted_datetime}</p>
                        <p class="text-xs text-gray-600">${event.venue.name}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-indigo-600 font-medium">${event.price}</span>
                            ${event.is_sold_out ? 
                                '<span class="text-xs text-red-600">Sold Out</span>' : 
                                `<span class="text-xs text-green-600">${event.available_tickets} left</span>`
                            }
                        </div>
                        ${event.category ? `<span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded mt-1">${event.category}</span>` : ''}
                    </div>
                    ${event.image ? `<img src="${event.image}" alt="${event.name}" class="w-12 h-12 object-cover rounded ml-2">` : ''}
                </div>
                <div class="mt-2 flex justify-end">
                    <a href="${event.url}" class="text-xs text-indigo-600 hover:text-indigo-800">View Details</a>
                </div>
            </div>
        `;
    }

    // Create event grid item
    function createEventGridItem(event) {
        return `
            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer" onclick="focusEventOnMap('${event.venue.id}')">
                ${event.image ? `
                    <img src="${event.image}" alt="${event.name}" class="w-full h-24 object-cover">
                ` : `
                    <div class="w-full h-24 bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                `}
                <div class="p-2">
                    <h4 class="text-xs font-medium text-gray-900 truncate">${event.name}</h4>
                    <p class="text-xs text-gray-600 truncate">${event.date}</p>
                    <p class="text-xs text-indigo-600 font-medium">${event.price}</p>
                </div>
            </div>
        `;
    }

    // Load popular locations
    function loadPopularLocations() {
        // This would typically be loaded from the backend
        const popularLocations = [
            { name: 'Downtown Convention Center', count: 45, id: 1 },
            { name: 'City Park Amphitheater', count: 32, id: 2 },
            { name: 'Sports Arena', count: 28, id: 3 },
            { name: 'University Campus', count: 22, id: 4 },
            { name: 'Art District', count: 18, id: 5 }
        ];

        const container = document.getElementById('popular-locations');
        container.innerHTML = popularLocations.map(location => `
            <button type="button" onclick="searchLocation('${location.name}')" class="w-full text-left px-2 py-1 text-xs hover:bg-gray-100 rounded">
                <span class="font-medium">${location.name}</span>
                <span class="text-gray-500 float-right">${location.count}</span>
            </button>
        `).join('');
    }

    // Search functionality
    let searchTimeout;
    document.getElementById('map-search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => searchMapEvents(query), 300);
        } else if (query.length === 0) {
            loadMapMarkers(currentFilters);
        }
    });

    // Map search events
    function searchMapEvents(query) {
        const params = new URLSearchParams({
            query: query,
            type: 'map',
            ...currentFilters
        });
        
        fetch(`<?php echo e(route('calendar.search')); ?>?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                // Convert search results to marker format and display
                displaySearchResults(data.results);
            })
            .catch(error => {
                console.error('Map search error:', error);
            });
    }

    // Display search results
    function displaySearchResults(results) {
        // Group results by venue
        const venueGroups = results.reduce((groups, event) => {
            const venueId = event.venue?.id || 'unknown';
            if (!groups[venueId]) {
                groups[venueId] = {
                    venue: event.venue || { name: 'Unknown Venue' },
                    events: []
                };
            }
            groups[venueId].events.push(event);
            return groups;
        }, {});

        // Convert to marker format
        const markerData = Object.values(venueGroups).map(group => ({
            latitude: group.venue.coordinates?.latitude || 0,
            longitude: group.venue.coordinates?.longitude || 0,
            venue: group.venue,
            events: group.events,
            event_count: group.events.length,
            color: '#3b82f6' // Default blue
        }));

        clearMarkers();
        addMarkers(markerData);
        updateEventList(markerData);
    }

    // Focus on specific event/venue on map
    window.focusEventOnMap = function(venueId) {
        const marker = markers.find(m => m.options.venueId === venueId);
        if (marker) {
            map.setView(marker.getLatLng(), 15);
            marker.openPopup();
        }
    };

    // Search location
    window.searchLocation = function(locationName) {
        document.getElementById('map-search').value = locationName;
        searchMapEvents(locationName);
    };

    // Filters
    document.getElementById('map-filters-btn').addEventListener('click', () => {
        document.getElementById('map-filters-modal').classList.remove('hidden');
    });

    document.getElementById('close-map-filters-modal').addEventListener('click', () => {
        document.getElementById('map-filters-modal').classList.add('hidden');
    });

    document.getElementById('map-filters-form').addEventListener('submit', function(e) {
        e.preventDefault();
        applyMapFilters();
        document.getElementById('map-filters-modal').classList.add('hidden');
    });

    document.getElementById('clear-map-filters-btn').addEventListener('click', () => {
        clearMapFilters();
    });

    // Apply map filters
    function applyMapFilters() {
        const form = document.getElementById('map-filters-form');
        const formData = new FormData(form);
        
        currentFilters = {};
        for (let [key, value] of formData.entries()) {
            if (value) currentFilters[key] = value;
        }
        
        loadMapMarkers(currentFilters);
    }

    // Clear map filters
    function clearMapFilters() {
        document.getElementById('map-filters-form').reset();
        currentFilters = {};
        loadMapMarkers();
    }

    // Find nearby events
    document.getElementById('find-nearby-btn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const radius = document.getElementById('search-radius').value;
                
                findNearbyEvents(latitude, longitude, radius);
                
                // Add user location marker
                if (userLocationMarker) {
                    map.removeLayer(userLocationMarker);
                }
                
                userLocationMarker = L.marker([latitude, longitude], {
                    icon: L.divIcon({
                        className: 'user-location-marker',
                        html: '<div class="user-marker"></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    })
                }).addTo(map);
                
                map.setView([latitude, longitude], 12);
            }, function() {
                alert('Unable to retrieve your location. Please enable location services.');
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    // Find nearby events
    function findNearbyEvents(latitude, longitude, radius) {
        const params = new URLSearchParams({
            latitude: latitude,
            longitude: longitude,
            radius: radius
        });
        
        fetch(`<?php echo e(route('calendar.events-nearby')); ?>?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                displayNearbyEvents(data.events);
            })
            .catch(error => {
                console.error('Error finding nearby events:', error);
            });
    }

    // Display nearby events
    function displayNearbyEvents(events) {
        // Group events by venue and display on map
        const venueGroups = events.reduce((groups, event) => {
            const venueId = event.venue?.id || 'unknown';
            if (!groups[venueId]) {
                groups[venueId] = {
                    venue: event.venue || { name: 'Unknown Venue' },
                    events: []
                };
            }
            groups[venueId].events.push(event);
            return groups;
        }, {});

        const markerData = Object.values(venueGroups).map(group => ({
            latitude: group.venue.coordinates?.latitude || 0,
            longitude: group.venue.coordinates?.longitude || 0,
            venue: group.venue,
            events: group.events,
            event_count: group.events.length,
            color: '#10b981' // Green for nearby events
        }));

        clearMarkers();
        addMarkers(markerData);
        updateEventList(markerData);
    }

    // Map controls
    document.getElementById('zoom-to-fit-btn').addEventListener('click', () => {
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    });

    document.getElementById('center-user-location-btn').addEventListener('click', () => {
        if (userLocationMarker) {
            map.setView(userLocationMarker.getLatLng(), 15);
        } else {
            document.getElementById('find-nearby-btn').click();
        }
    });

    // Map layer control
    document.getElementById('map-layer-select').addEventListener('change', function() {
        // This would change map layers if using Google Maps
        // With OpenStreetMap, we'd need to implement different tile servers
    });

    // View toggle buttons
    document.getElementById('list-view-btn').addEventListener('click', function() {
        this.classList.add('active');
        document.getElementById('grid-view-btn').classList.remove('active');
        // Reload current events in list view
        loadMapMarkers(currentFilters);
    });

    document.getElementById('grid-view-btn').addEventListener('click', function() {
        this.classList.add('active');
        document.getElementById('list-view-btn').classList.remove('active');
        // Reload current events in grid view
        loadMapMarkers(currentFilters);
    });

    // Cluster toggle
    document.getElementById('show-clusters').addEventListener('change', function() {
        if (this.checked) {
            if (!map.hasLayer(markerClusterGroup)) {
                map.addLayer(markerClusterGroup);
            }
        } else {
            if (map.hasLayer(markerClusterGroup)) {
                map.removeLayer(markerClusterGroup);
                // Add individual markers
                markers.forEach(marker => {
                    map.addLayer(marker);
                });
            }
        }
    });

    // Loading states
    function showMapLoading() {
        document.getElementById('map-loading').classList.remove('hidden');
    }

    function hideMapLoading() {
        document.getElementById('map-loading').classList.add('hidden');
    }

    // Update visible markers based on map bounds
    function updateVisibleMarkers() {
        // This could be used to load markers dynamically as the user pans
    }

    // Show venue details
    window.showVenueDetails = function(venueId) {
        // Navigate to venue page or show venue events
        window.location.href = `/venues/${venueId}`;
    };

    // Show event details popup
    function showEventDetails(markerData) {
        // Implementation for showing detailed event popup
    }

    // Initialize the map when page loads
    initializeMap();
});
</script>

<style>
.custom-marker {
    background: transparent !important;
    border: none !important;
}

.marker-pin {
    width: 24px;
    height: 24px;
    border-radius: 50% 50% 50% 0;
    background: #3b82f6;
    position: relative;
    transform: rotate(-45deg);
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.marker-pin:after {
    content: '';
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
    position: absolute;
    top: 6px;
    left: 6px;
}

.marker-count {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    color: white;
    font-size: 10px;
    font-weight: bold;
    line-height: 1;
}

.user-location-marker {
    background: transparent !important;
    border: none !important;
}

.user-marker {
    width: 16px;
    height: 16px;
    background: #ef4444;
    border: 3px solid #fff;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.marker-cluster-small {
    background-color: rgba(59, 130, 246, 0.8);
}

.marker-cluster-medium {
    background-color: rgba(245, 158, 11, 0.8);
}

.marker-cluster-large {
    background-color: rgba(239, 68, 68, 0.8);
}

.marker-cluster div {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    color: white;
    font-weight: bold;
    text-align: center;
    line-height: 40px;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/calendar/map.blade.php ENDPATH**/ ?>