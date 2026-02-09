<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';
    
    protected $fillable = [
        'name',
        'description',
        'address',
        'email',
        'phone',
        'website',
        'capacity',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'country_code',
        'postal_code',
        'amenities',
        'directions',
        'is_verified'
    ];

    protected $casts = [
        'amenities' => 'json',
        'is_verified' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function upcomingEvents(): HasMany
    {
        return $this->hasMany(Event::class)->where('date', '>=', now());
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeWithinDistance($query, $latitude, $longitude, $radius = 50)
    {
        // Using Haversine formula to calculate distance in kilometers
        return $query->selectRaw("
            *, (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )
            ) AS distance
        ", [$latitude, $longitude, $latitude])
        ->having('distance', '<', $radius)
        ->orderBy('distance');
    }

    public function scopeInCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    public function scopeInCountry($query, $country)
    {
        return $query->where('country', 'like', "%{$country}%");
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    public function getCoordinatesAttribute(): ?array
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude
            ];
        }

        return null;
    }

    public function getMapUrlAttribute(): string
    {
        if ($this->coordinates) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return "https://www.google.com/maps/search/" . urlencode($this->full_address);
    }

    public function getDirectionsUrlAttribute(): string
    {
        if ($this->coordinates) {
            return "https://www.google.com/maps/dir/?api=1&destination={$this->latitude},{$this->longitude}";
        }

        return "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($this->full_address);
    }

    // Helper Methods
    public function hasCoordinates(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function getDistanceFrom($latitude, $longitude): float
    {
        if (!$this->hasCoordinates()) {
            return 0;
        }

        // Haversine formula
        $earthRadius = 6371; // kilometers

        $latFrom = deg2rad($latitude);
        $lonFrom = deg2rad($longitude);
        $latTo = deg2rad($this->latitude);
        $lonTo = deg2rad($this->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function getFormattedDistance($latitude, $longitude): string
    {
        $distance = $this->getDistanceFrom($latitude, $longitude);
        
        if ($distance < 1) {
            return number_format($distance * 1000, 0) . 'm away';
        }

        return number_format($distance, 1) . 'km away';
    }

    // Geocoding Methods
    public function geocodeAddress(): bool
    {
        if (!$this->address) {
            return false;
        }

        try {
            // Using a simple geocoding service (you can replace with Google Maps API)
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $this->full_address,
                'format' => 'json',
                'limit' => 1
            ]);

            $data = $response->json();

            if (!empty($data)) {
                $this->latitude = $data[0]['lat'];
                $this->longitude = $data[0]['lon'];
                
                // Extract additional location details if available
                if (isset($data[0]['display_name'])) {
                    $this->extractLocationDetails($data[0]);
                }

                $this->save();
                return true;
            }
        } catch (\Exception $e) {
            \Log::error('Geocoding failed for venue: ' . $this->id, [
                'error' => $e->getMessage(),
                'address' => $this->full_address
            ]);
        }

        return false;
    }

    private function extractLocationDetails($geocodeData): void
    {
        // Extract city, state, country from geocoding result
        $addressComponents = $geocodeData['display_name'] ?? '';
        
        // This is a simple extraction - you might want to use more sophisticated parsing
        if (isset($geocodeData['address'])) {
            $address = $geocodeData['address'];
            
            $this->city = $address['city'] ?? $address['town'] ?? $address['village'] ?? $this->city;
            $this->state = $address['state'] ?? $this->state;
            $this->country = $address['country'] ?? $this->country;
            $this->postal_code = $address['postcode'] ?? $this->postal_code;
        }
    }

    public static function findNearby($latitude, $longitude, $radius = 50, $limit = 10)
    {
        return self::withinDistance($latitude, $longitude, $radius)
                   ->verified()
                   ->with('upcomingEvents')
                   ->limit($limit)
                   ->get();
    }

    public function toMapMarker(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->full_address,
            'coordinates' => $this->coordinates,
            'capacity' => $this->capacity,
            'events_count' => $this->upcomingEvents->count(),
            'map_url' => $this->map_url,
            'directions_url' => $this->directions_url,
            'phone' => $this->phone,
            'website' => $this->website,
            'amenities' => $this->amenities ?? [],
            'is_verified' => $this->is_verified
        ];
    }
}