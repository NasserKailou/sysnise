<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CadreDeveloppement;

class CadreDeveloppementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CadreDeveloppement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'structure_responsable' => fake()->regexify('[A-Za-z0-9]{255}'),
            'periode_debut' => fake()->regexify('[A-Za-z0-9]{255}'),
            'periode_fin' => fake()->regexify('[A-Za-z0-9]{255}'),
            'description' => fake()->text(),
            'cadre_developpement_id' => CadreDeveloppement::factory(),
        ];
    }
}
