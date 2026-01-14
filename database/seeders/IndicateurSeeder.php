<?php

namespace Database\Seeders;

use App\Models\Indicateur;
use Illuminate\Database\Seeder;

class IndicateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Indicateur::factory()->count(5)->create();
    }
}
