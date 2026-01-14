<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Zone;

class ZoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Zone::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->regexify('[A-Za-z0-9]{255}'),
            'code' => fake()->regexify('[A-Za-z0-9]{255}'),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'zone_id' => Zone::factory(),
            'niveau' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
