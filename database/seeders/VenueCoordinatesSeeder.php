<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;

class VenueCoordinatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample venues with coordinates (New York City area)
        $venues = [
            [
                'name' => 'Madison Square Garden',
                'description' => 'World-famous arena in the heart of Manhattan',
                'address' => '4 Pennsylvania Plaza, New York, NY 10001',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10001',
                'phone' => '+1 (212) 465-6000',
                'email' => 'info@msg.com',
                'website' => 'https://www.msg.com',
                'capacity' => 20789,
                'latitude' => 40.7505,
                'longitude' => -73.9934,
            ],
            [
                'name' => 'Central Park Conservancy',
                'description' => 'Beautiful outdoor venue in Central Park',
                'address' => '14 E 60th St, New York, NY 10022',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10022',
                'phone' => '+1 (212) 310-6600',
                'email' => 'info@centralparknyc.org',
                'website' => 'https://www.centralparknyc.org',
                'capacity' => 5000,
                'latitude' => 40.7829,
                'longitude' => -73.9654,
            ],
            [
                'name' => 'Brooklyn Bridge Park',
                'description' => 'Stunning waterfront park with Manhattan skyline views',
                'address' => '334 Furman St, Brooklyn, NY 11201',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '11201',
                'phone' => '+1 (718) 222-9939',
                'email' => 'info@brooklynbridgepark.org',
                'website' => 'https://www.brooklynbridgepark.org',
                'capacity' => 3000,
                'latitude' => 40.7024,
                'longitude' => -73.9973,
            ],
            [
                'name' => 'Lincoln Center',
                'description' => 'Premier performing arts venue',
                'address' => '10 Lincoln Center Plaza, New York, NY 10023',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10023',
                'phone' => '+1 (212) 875-5456',
                'email' => 'customerservice@lincolncenter.org',
                'website' => 'https://www.lincolncenter.org',
                'capacity' => 2738,
                'latitude' => 40.7722,
                'longitude' => -73.9834,
            ],
            [
                'name' => 'Times Square Conference Center',
                'description' => 'Modern conference facility in Times Square',
                'address' => '1500 Broadway, New York, NY 10036',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10036',
                'phone' => '+1 (212) 789-1234',
                'email' => 'events@tscc.com',
                'website' => 'https://www.timessquarecc.com',
                'capacity' => 1200,
                'latitude' => 40.7590,
                'longitude' => -73.9845,
            ],
            [
                'name' => 'High Line Venue',
                'description' => 'Unique elevated park venue',
                'address' => 'High Line, New York, NY 10011',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10011',
                'phone' => '+1 (212) 500-6035',
                'email' => 'info@thehighline.org',
                'website' => 'https://www.thehighline.org',
                'capacity' => 800,
                'latitude' => 40.7480,
                'longitude' => -74.0048,
            ]
        ];

        foreach ($venues as $venueData) {
            Venue::firstOrCreate(
                ['name' => $venueData['name']],
                $venueData
            );
        }

        // Create sample categories if they don't exist
        $categories = [
            ['name' => 'Concerts', 'slug' => 'concerts', 'description' => 'Musical performances and live concerts', 'color' => '#8b5cf6', 'is_active' => true],
            ['name' => 'Conferences', 'slug' => 'conferences', 'description' => 'Professional conferences and seminars', 'color' => '#3b82f6', 'is_active' => true],
            ['name' => 'Workshops', 'slug' => 'workshops', 'description' => 'Educational workshops and training sessions', 'color' => '#10b981', 'is_active' => true],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sporting events and competitions', 'color' => '#f97316', 'is_active' => true],
            ['name' => 'Exhibitions', 'slug' => 'exhibitions', 'description' => 'Art exhibitions and galleries', 'color' => '#06b6d4', 'is_active' => true],
            ['name' => 'Networking', 'slug' => 'networking', 'description' => 'Business networking events', 'color' => '#84cc16', 'is_active' => true],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Get or create a user for event creation
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Event Manager',
                'email' => 'manager@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Create sample events with different venues and times
        $events = [
            [
                'name' => 'New York Tech Conference 2024',
                'description' => 'Annual technology conference featuring industry leaders and cutting-edge innovations.',
                'venue' => 'Madison Square Garden',
                'category' => 'conferences',
                'date' => now()->addDays(5)->setHour(9)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(5)->setHour(17)->setMinute(0)->setSecond(0),
                'price' => 299.00,
                'capacity' => 1500,
                'is_featured' => true,
            ],
            [
                'name' => 'Summer Music Festival',
                'description' => 'Three-day outdoor music festival featuring top artists from around the world.',
                'venue' => 'Central Park Conservancy',
                'category' => 'concerts',
                'date' => now()->addDays(15)->setHour(14)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(17)->setHour(23)->setMinute(0)->setSecond(0),
                'price' => 150.00,
                'capacity' => 3000,
                'is_featured' => true,
            ],
            [
                'name' => 'Brooklyn Art Exhibition',
                'description' => 'Contemporary art exhibition showcasing local and international artists.',
                'venue' => 'Brooklyn Bridge Park',
                'category' => 'exhibitions',
                'date' => now()->addDays(8)->setHour(10)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(8)->setHour(18)->setMinute(0)->setSecond(0),
                'price' => 25.00,
                'capacity' => 500,
                'is_featured' => false,
            ],
            [
                'name' => 'Classical Music Gala',
                'description' => 'An evening of classical music performed by the New York Philharmonic.',
                'venue' => 'Lincoln Center',
                'category' => 'concerts',
                'date' => now()->addDays(12)->setHour(19)->setMinute(30)->setSecond(0),
                'end_date' => now()->addDays(12)->setHour(22)->setMinute(0)->setSecond(0),
                'price' => 85.00,
                'capacity' => 2000,
                'is_featured' => false,
            ],
            [
                'name' => 'Digital Marketing Workshop',
                'description' => 'Intensive workshop on modern digital marketing strategies and tools.',
                'venue' => 'Times Square Conference Center',
                'category' => 'workshops',
                'date' => now()->addDays(3)->setHour(9)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(3)->setHour(16)->setMinute(0)->setSecond(0),
                'price' => 129.00,
                'capacity' => 100,
                'is_featured' => false,
            ],
            [
                'name' => 'Startup Networking Mixer',
                'description' => 'Connect with entrepreneurs, investors, and innovators in the startup ecosystem.',
                'venue' => 'High Line Venue',
                'category' => 'networking',
                'date' => now()->addDays(7)->setHour(18)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(7)->setHour(21)->setMinute(0)->setSecond(0),
                'price' => 0.00,
                'capacity' => 200,
                'is_featured' => false,
            ],
            [
                'name' => 'Photography Masterclass',
                'description' => 'Learn advanced photography techniques from professional photographers.',
                'venue' => 'Brooklyn Bridge Park',
                'category' => 'workshops',
                'date' => now()->addDays(20)->setHour(10)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(20)->setHour(15)->setMinute(0)->setSecond(0),
                'price' => 75.00,
                'capacity' => 50,
                'is_featured' => false,
            ],
            [
                'name' => 'Business Leaders Summit',
                'description' => 'Annual summit bringing together top business leaders and executives.',
                'venue' => 'Madison Square Garden',
                'category' => 'conferences',
                'date' => now()->addDays(25)->setHour(8)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(25)->setHour(18)->setMinute(0)->setSecond(0),
                'price' => 495.00,
                'capacity' => 800,
                'is_featured' => true,
            ]
        ];

        foreach ($events as $eventData) {
            $venue = Venue::where('name', $eventData['venue'])->first();
            $category = Category::where('slug', $eventData['category'])->first();

            if ($venue && $category) {
                Event::firstOrCreate(
                    ['name' => $eventData['name']],
                    [
                        'name' => $eventData['name'],
                        'description' => $eventData['description'],
                        'date' => $eventData['date'],
                        'end_date' => $eventData['end_date'],
                        'venue_id' => $venue->id,
                        'category_id' => $category->id,
                        'user_id' => $user->id,
                        'price' => $eventData['price'],
                        'capacity' => $eventData['capacity'],
                        'is_featured' => $eventData['is_featured'],
                        'status' => 'active',
                        'allow_registrations' => true,
                        'organizer_name' => $user->name,
                        'organizer_email' => $user->email,
                    ]
                );
            }
        }

        echo "✅ Sample venues and events with coordinates created successfully!\n";
        echo "📍 Venues created: " . Venue::count() . "\n";
        echo "🎉 Events created: " . Event::count() . "\n";
        echo "📂 Categories created: " . Category::count() . "\n";
    }
}
