<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CadreLogique;

class CadreLogiqueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CadreLogique::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'niveau' => fake()->numberBetween(-10000, 10000),
            'cadre_logique_id' => CadreLogique::factory(),
        ];
    }
}
