<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        $name = $this->faker->sentence(3);

        return [
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'location' => $this->faker->address(),
            'status' => 'active',
            'capacity' => $this->faker->numberBetween(10, 1000),
            'price' => $this->faker->randomFloat(2, 0, 200),
            'category' => $this->faker->randomElement(['Music','Conference','Meetup','Workshop']),
            'is_featured' => false,
        ];
    }
}
