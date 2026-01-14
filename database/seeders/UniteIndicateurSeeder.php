<?php

namespace Database\Seeders;

use App\Models\UniteIndicateur;
use Illuminate\Database\Seeder;

class UniteIndicateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniteIndicateur::factory()->count(5)->create();
    }
}
