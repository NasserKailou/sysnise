<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PieceJointe;

class PieceJointeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PieceJointe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'lien' => fake()->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
