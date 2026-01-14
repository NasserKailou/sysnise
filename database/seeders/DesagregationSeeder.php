<?php

namespace Database\Seeders;

use App\Models\Desagregation;
use Illuminate\Database\Seeder;

class DesagregationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Desagregation::factory()->count(5)->create();
    }
}
