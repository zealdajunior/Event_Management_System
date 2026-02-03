<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Music & Concerts',
                'description' => 'Live music performances, concerts, and musical events',
                'icon' => 'music',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Sports & Recreation',
                'description' => 'Sports events, tournaments, and recreational activities',
                'icon' => 'football',
                'color' => '#10B981',
                'sort_order' => 2,
            ],
            [
                'name' => 'Business & Professional',
                'description' => 'Business conferences, networking events, and professional seminars',
                'icon' => 'briefcase',
                'color' => '#6366F1',
                'sort_order' => 3,
            ],
            [
                'name' => 'Education & Workshops',
                'description' => 'Educational seminars, workshops, and training sessions',
                'icon' => 'book',
                'color' => '#8B5CF6',
                'sort_order' => 4,
            ],
            [
                'name' => 'Arts & Culture',
                'description' => 'Art exhibitions, cultural events, and creative workshops',
                'icon' => 'palette',
                'color' => '#EC4899',
                'sort_order' => 5,
            ],
            [
                'name' => 'Food & Drink',
                'description' => 'Food festivals, wine tastings, and culinary events',
                'icon' => 'utensils',
                'color' => '#F59E0B',
                'sort_order' => 6,
            ],
            [
                'name' => 'Technology',
                'description' => 'Tech conferences, startup events, and innovation forums',
                'icon' => 'laptop',
                'color' => '#06B6D4',
                'sort_order' => 7,
            ],
            [
                'name' => 'Health & Wellness',
                'description' => 'Fitness classes, wellness workshops, and health seminars',
                'icon' => 'heart',
                'color' => '#EF4444',
                'sort_order' => 8,
            ],
            [
                'name' => 'Family & Kids',
                'description' => 'Family-friendly events and activities for children',
                'icon' => 'baby',
                'color' => '#F97316',
                'sort_order' => 9,
            ],
            [
                'name' => 'Other',
                'description' => 'Miscellaneous events that don\'t fit other categories',
                'icon' => 'calendar',
                'color' => '#64748B',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
