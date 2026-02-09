// Event Creation Form Enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Google Places Autocomplete
    if (typeof google !== 'undefined' && google.maps) {
        initializeGooglePlaces();
    }
    
    // Initialize Pricing Suggestions
    initializePricingSuggestions();
    
    // Initialize Venue Suggestions
    initializeVenueSuggestions();
});

/**
 * Initialize Google Places Autocomplete for location field
 */
function initializeGooglePlaces() {
    const locationInput = document.getElementById('location');
    if (!locationInput) return;
    
    const autocomplete = new google.maps.places.Autocomplete(locationInput, {
        types: ['establishment', 'geocode'],
        fields: ['formatted_address', 'geometry', 'name', 'address_components', 'place_id']
    });
    
    autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();
        
        if (!place.geometry) {
            showNotification('Please select a location from the suggestions', 'warning');
            return;
        }
        
        // Fill in coordinates
        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
        
        // Extract address components
        let country = '';
        let countryCode = '';
        let city = '';
        let state = '';
        let postalCode = '';
        
        place.address_components.forEach(component => {
            const types = component.types;
            
            if (types.includes('country')) {
                country = component.long_name;
                countryCode = component.short_name;
            }
            if (types.includes('locality')) {
                city = component.long_name;
            }
            if (types.includes('administrative_area_level_1')) {
                state = component.short_name;
            }
            if (types.includes('postal_code')) {
                postalCode = component.long_name;
            }
        });
        
        // Fill in country code if field exists
        const countryCodeInput = document.getElementById('country_code');
        if (countryCodeInput) {
            countryCodeInput.value = countryCode;
        }
        
        // Auto-fill venue name if empty and place has a name
        const venueNameInput = document.getElementById('venue_name');
        if (venueNameInput && !venueNameInput.value && place.name) {
            venueNameInput.value = place.name;
        }
        
        // Update location display
        locationInput.value = place.formatted_address;
        
        // Show success notification
        showNotification('✓ Location coordinates captured! Event will appear on map', 'success');
        
        // Trigger Alpine.js update
        locationInput.dispatchEvent(new Event('input'));
    });
}

/**
 * Initialize intelligent pricing suggestions
 */
function initializePricingSuggestions() {
    const categorySelect = document.getElementById('category_id');
    const priceInput = document.getElementById('price');
    const capacityInput = document.getElementById('capacity');
    
    if (!categorySelect || !priceInput) return;
    
    // Pricing suggestions based on category
    const pricingSuggestions = {
        'music': [15, 25, 50],
        'concert': [20, 35, 75],
        'conference': [50, 150, 300],
        'workshop': [25, 50, 100],
        'sports': [10, 25, 50],
        'festival': [20, 40, 80],
        'food': [15, 30, 60],
        'tech': [30, 75, 150],
        'business': [50, 100, 200],
        'networking': [20, 40, 75],
        'default': [10, 25, 50]
    };
    
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const categoryName = selectedOption.text.toLowerCase();
        
        // Find matching pricing tier
        let suggestions = pricingSuggestions.default;
        for (let key in pricingSuggestions) {
            if (categoryName.includes(key)) {
                suggestions = pricingSuggestions[key];
                break;
            }
        }
        
        // Update price suggestion buttons if they exist
        updatePriceSuggestionButtons(suggestions);
    });
}

/**
 * Update price suggestion buttons
 */
function updatePriceSuggestionButtons(suggestions) {
    const buttons = document.querySelectorAll('[data-price-suggestion]');
    if (buttons.length < 3) return;
    
    buttons[0].querySelector('.text-blue-600').textContent = '$' + suggestions[0];
    buttons[1].querySelector('.text-blue-600').textContent = '$' + suggestions[1];
    buttons[2].querySelector('.text-blue-600').textContent = '$' + suggestions[2];
    
    buttons[0].setAttribute('data-price', suggestions[0]);
    buttons[1].setAttribute('data-price', suggestions[1]);
    buttons[2].setAttribute('data-price', suggestions[2]);
}

/**
 * Initialize venue suggestions from database
 */
function initializeVenueSuggestions() {
    const locationInput = document.getElementById('location');
    const venueNameInput = document.getElementById('venue_name');
    
    if (!locationInput || !venueNameInput) return;
    
    // Create suggestions dropdown
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.className = 'absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto';
    suggestionsContainer.id = 'venue-suggestions';
    locationInput.parentElement.style.position = 'relative';
    locationInput.parentElement.appendChild(suggestionsContainer);
    
    // Debounce function
    let timeout;
    locationInput.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value;
        
        if (query.length < 3) {
            suggestionsContainer.classList.add('hidden');
            return;
        }
        
        timeout = setTimeout(() => {
            fetchVenueSuggestions(query, suggestionsContainer);
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!locationInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.add('hidden');
        }
    });
}

/**
 * Fetch venue suggestions from database
 */
async function fetchVenueSuggestions(query, container) {
    try {
        const response = await fetch(`/api/venues/search?q=${encodeURIComponent(query)}`);
        const venues = await response.json();
        
        if (venues.length === 0) {
            container.classList.add('hidden');
            return;
        }
        
        // Render suggestions
        container.innerHTML = venues.map(venue => `
            <div class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 venue-suggestion" 
                 data-venue='${JSON.stringify(venue)}'>
                <div class="font-semibold text-gray-900">${venue.name}</div>
                <div class="text-sm text-gray-600">${venue.address}</div>
                <div class="text-xs text-gray-500 mt-1">
                    ${venue.city ? venue.city + ', ' : ''}${venue.country || ''}
                    ${venue.capacity ? ' • Capacity: ' + venue.capacity : ''}
                </div>
            </div>
        `).join('');
        
        container.classList.remove('hidden');
        
        // Add click handlers
        container.querySelectorAll('.venue-suggestion').forEach(item => {
            item.addEventListener('click', function() {
                const venue = JSON.parse(this.dataset.venue);
                selectVenue(venue);
                container.classList.add('hidden');
            });
        });
        
    } catch (error) {
        console.error('Error fetching venue suggestions:', error);
    }
}

/**
 * Select a venue from suggestions
 */
function selectVenue(venue) {
    document.getElementById('location').value = venue.address;
    document.getElementById('venue_name').value = venue.name;
    
    if (venue.latitude) document.getElementById('latitude').value = venue.latitude;
    if (venue.longitude) document.getElementById('longitude').value = venue.longitude;
    if (venue.country_code) {
        const countryCodeInput = document.getElementById('country_code');
        if (countryCodeInput) countryCodeInput.value = venue.country_code;
    }
    if (venue.capacity) {
        document.getElementById('capacity').value = venue.capacity;
    }
    
    showNotification('✓ Venue selected! Details auto-filled', 'success');
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const colors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'warning': 'bg-yellow-500',
        'info': 'bg-blue-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Calculate profit after platform fees
 */
function calculateProfit(revenue, platformFee = 0.1) {
    const profit = revenue * (1 - platformFee);
    return {
        revenue: revenue.toFixed(2),
        platformFee: (revenue * platformFee).toFixed(2),
        profit: profit.toFixed(2),
        profitPercentage: ((profit / revenue) * 100).toFixed(1)
    };
}
