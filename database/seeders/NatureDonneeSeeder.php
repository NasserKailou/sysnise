<?php

namespace Database\Seeders;

use App\Models\NatureDonnee;
use Illuminate\Database\Seeder;

class NatureDonneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NatureDonnee::factory()->count(5)->create();
    }
}
