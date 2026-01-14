<?php

namespace Database\Seeders;

use App\Models\SourceIndicateur;
use Illuminate\Database\Seeder;

class SourceIndicateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SourceIndicateur::factory()->count(5)->create();
    }
}
