<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\UniteIndicateur;

class UniteIndicateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniteIndicateur::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
