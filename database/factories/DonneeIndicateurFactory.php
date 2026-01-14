<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CommentaireValeurIndicateur;
use App\Models\Desagregation;
use App\Models\DonneeIndicateur;
use App\Models\Indicateur;
use App\Models\NatureDonnee;
use App\Models\Periode;
use App\Models\SourceIndicateur;
use App\Models\UniteIndicateur;
use App\Models\Zone;

class DonneeIndicateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DonneeIndicateur::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nature_donnee_id' => NatureDonnee::factory(),
            'indicateur_id' => Indicateur::factory(),
            'zone_id' => Zone::factory(),
            'periode_id' => Periode::factory(),
            'desagregation_id' => Desagregation::factory(),
            'source_indicateur_id' => SourceIndicateur::factory(),
            'unite_indicateur_id' => UniteIndicateur::factory(),
            'commentaire_valeur_indicateur_id' => CommentaireValeurIndicateur::factory(),
            'valeur' => fake()->randomFloat(0, 0, 9999999999.),
        ];
    }
}
