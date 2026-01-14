<?php

namespace Database\Seeders;

use App\Models\CadreDeveloppement;
use Illuminate\Database\Seeder;

class CadreDeveloppementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CadreDeveloppement::factory()->count(5)->create();
    }
}
