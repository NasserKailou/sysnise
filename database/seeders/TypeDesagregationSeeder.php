<?php

namespace Database\Seeders;

use App\Models\TypeDesagregation;
use Illuminate\Database\Seeder;

class TypeDesagregationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeDesagregation::factory()->count(5)->create();
    }
}
