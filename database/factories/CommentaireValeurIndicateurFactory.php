<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CommentaireValeurIndicateur;

class CommentaireValeurIndicateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentaireValeurIndicateur::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'description' => fake()->text(),
        ];
    }
}
