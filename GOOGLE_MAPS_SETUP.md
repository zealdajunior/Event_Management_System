# Google Maps Integration Setup Guide

## Overview
The user dashboard now includes an interactive Google Maps view that displays all events with location data as markers on the map. Events with real location names (latitude/longitude) appear as clickable icons.

## Features Added

### 1. **Interactive Event Map**
- Located at the top of the Events tab
- Shows all events that have location coordinates
- Color-coded markers:
  - 🔵 **Blue markers**: Featured events
  - 🟢 **Green markers**: Regular events
  - 🔴 **Red marker**: Your current location

### 2. **Marker Features**
- Click any marker to see event details in an info window
- Info windows show:
  - Event name
  - Date and time
  - Location/venue name
  - Category
  - Price
  - Featured status
  - "View Details" button linking to the event page

### 3. **Map Controls**
- **"Center on Me"** button: Centers map on your current location
- **Pan & Zoom**: Standard Google Maps controls
- **Full Screen**: Expand map to full screen
- Auto-fit bounds to show all event markers

### 4. **Complete Calendar Implementation**
- Interactive calendar grid with event indicators
- Click any date to see events for that day
- Events sidebar filters by selected date
- Visual indicators:
  - Blue background = date has events
  - Blue highlight = today or selected date
  - Small dots = number of events (up to 3)
- Month navigation with Previous/Next/Today buttons

## Setup Instructions

### Step 1: Get Google Maps API Key

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the following APIs:
   - **Maps JavaScript API**
   - **Places API** (optional, for future features)
   - **Geocoding API** (optional, for address-to-coordinates conversion)

4. Create an API key:
   - Navigate to **APIs & Services** > **Credentials**
   - Click **+ CREATE CREDENTIALS** > **API key**
   - Copy the generated API key
   - (Optional) Restrict the API key to your domain for security

### Step 2: Add API Key to Environment

1. Open your `.env` file
2. Add the Google Maps API key:

```env
GOOGLE_MAPS_API_KEY=your_actual_api_key_here
```

3. Clear the config cache:
```bash
php artisan config:clear
php artisan view:clear
```

### Step 3: Add Location Data to Events

For events to appear on the map, they need latitude and longitude coordinates. You can add these in two ways:

#### Option A: Via Venue Table
If your events use the `venues` table:

```sql
-- Add coordinates to venues table (if not exists)
ALTER TABLE venues ADD COLUMN latitude DECIMAL(10, 8) NULL;
ALTER TABLE venues ADD COLUMN longitude DECIMAL(11, 8) NULL;

-- Example: Update a venue with coordinates
UPDATE venues 
SET latitude = 40.7589, longitude = -73.9851 
WHERE name = 'Times Square';
```

#### Option B: Via Events Table Directly
```sql
-- Add coordinates to events table (if not exists)
ALTER TABLE events ADD COLUMN latitude DECIMAL(10, 8) NULL;
ALTER TABLE events ADD COLUMN longitude DECIMAL(11, 8) NULL;

-- Example: Update an event with coordinates
UPDATE events 
SET latitude = 40.7589, longitude = -73.9851 
WHERE id = 1;
```

### Step 4: Test the Integration

1. Start your development server:
```bash
php artisan serve
```

2. Navigate to the dashboard: `http://127.0.0.1:8000/dashboard`

3. Click on the **Events** tab

4. You should see:
   - An interactive map at the top
   - Event markers on the map (if events have coordinates)
   - Clickable markers with event info

### Step 5: Enable User Location (Optional)

For the "Center on Me" feature to work:
- Users need to grant location permissions in their browser
- The site should be served over HTTPS (or localhost for development)

## Finding Coordinates for Locations

### Method 1: Google Maps
1. Go to [Google Maps](https://maps.google.com)
2. Right-click on a location
3. Click the coordinates to copy them
4. Format: `latitude, longitude` (e.g., `40.7589, -73.9851`)

### Method 2: Geocoding API (Automated)
You can create a command to automatically geocode venue addresses:

```php
// Example: Get coordinates from address
use Illuminate\Support\Facades\Http;

$address = urlencode("123 Main St, New York, NY");
$apiKey = config('services.google_maps.api_key');
$response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}");

if ($response->successful()) {
    $result = $response->json();
    $location = $result['results'][0]['geometry']['location'];
    $latitude = $location['lat'];
    $longitude = $location['lng'];
}
```

## Calendar Features

### How It Works
1. **Calendar Grid**: Shows current month with all dates
2. **Event Indicators**: Dates with events show blue background and dots
3. **Date Selection**: Click a date to filter events in the sidebar
4. **Navigation**: Use Previous/Next buttons or "Today" to navigate months
5. **Event Details**: Each event card in the sidebar is clickable to view full details

### Calendar Color Coding
- **Blue background**: Date has events
- **Bright blue with ring**: Today or selected date
- **Small dots**: Visual count of events (1-3 dots)
- **Gray**: Dates outside current month

## Troubleshooting

### Map Not Loading
- **Check API Key**: Ensure `GOOGLE_MAPS_API_KEY` is set in `.env`
- **Check Console**: Open browser developer tools for error messages
- **API Restrictions**: Make sure your API key allows requests from your domain
- **Billing**: Ensure billing is enabled in Google Cloud Console

### No Markers Showing
- **Check Coordinates**: Verify events have valid `latitude` and `longitude` values
- **Check Values**: Coordinates should not be `null`, `0`, or empty
- **Database Query**: Ensure the venue relationship is loaded properly

### "Center on Me" Not Working
- **HTTPS Required**: Browser geolocation requires HTTPS (or localhost)
- **Permissions**: User must grant location permission
- **Browser Support**: Ensure browser supports geolocation API

### Calendar Not Showing Events
- **Check Dates**: Ensure events have valid `date` field values
- **Future Dates**: Only future events are displayed by default
- **Format**: Dates should be in `YYYY-MM-DD` format

## API Usage & Costs

### Google Maps Pricing
- **Maps JavaScript API**: $7 per 1,000 requests (first $200/month free)
- **Free Tier**: Includes $200 credit per month (~28,000 map loads)
- **Static Maps**: Alternative cheaper option if interactivity isn't needed

### Optimization Tips
1. **Restrict API Key**: Limit to your domain only
2. **Cache Results**: Cache geocoding results to reduce API calls
3. **Lazy Load**: Map only loads when Events tab is active
4. **Set Limits**: Set daily quotas in Google Cloud Console

## Future Enhancements

### Potential Features
- **Cluster Markers**: Group nearby events into clusters
- **Search Box**: Search for locations on the map
- **Directions**: Get directions to event location
- **Filter by Distance**: Show events within X miles of user
- **Heatmap**: Show event density visualization
- **Street View**: Preview venue in Street View
- **Custom Markers**: Different icons for different event categories

### Calendar Enhancements
- **Multi-day Events**: Show events spanning multiple days
- **Event Colors**: Color-code events by category
- **Drag & Drop**: Create events by clicking calendar dates
- **Month View Toggle**: Switch between month/week/day views
- **Export to Calendar**: Download .ics file for selected events

## Support

For issues or questions:
1. Check the browser console for JavaScript errors
2. Verify API key is valid and has proper permissions
3. Ensure database has location data for events
4. Check Laravel logs: `storage/logs/laravel.log`

## Resources

- [Google Maps JavaScript API Documentation](https://developers.google.com/maps/documentation/javascript)
- [Google Maps Pricing](https://developers.google.com/maps/billing/gmp-billing)
- [Geocoding API Guide](https://developers.google.com/maps/documentation/geocoding)
- [Browser Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
