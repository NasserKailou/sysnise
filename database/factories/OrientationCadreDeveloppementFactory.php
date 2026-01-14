<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CadreDeveloppement;
use App\Models\CadreLogique;
use App\Models\OrientationCadreDeveloppement;

class OrientationCadreDeveloppementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrientationCadreDeveloppement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'cadre_developpement_id' => CadreDeveloppement::factory(),
            'cadre_logique_id' => CadreLogique::factory(),
        ];
    }
}
