<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Indicateur;

class IndicateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Indicateur::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => fake()->regexify('[A-Za-z0-9]{255}'),
            'intitule' => fake()->regexify('[A-Za-z0-9]{255}'),
            'definition' => fake()->regexify('[A-Za-z0-9]{255}'),
            'donnees_requises' => fake()->regexify('[A-Za-z0-9]{255}'),
            'methode_calcul' => fake()->regexify('[A-Za-z0-9]{255}'),
            'methode_collecte' => fake()->regexify('[A-Za-z0-9]{255}'),
            'source' => fake()->regexify('[A-Za-z0-9]{255}'),
            'commentaire_limite' => fake()->regexify('[A-Za-z0-9]{255}'),
            'niveau_desagregation' => fake()->regexify('[A-Za-z0-9]{255}'),
            'periodicite' => fake()->regexify('[A-Za-z0-9]{255}'),
            'unite' => fake()->regexify('[A-Za-z0-9]{255}'),
            'echelle' => fake()->regexify('[A-Za-z0-9]{255}'),
            'lien_avec_cadre_developpement' => fake()->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
