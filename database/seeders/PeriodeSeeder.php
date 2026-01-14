<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Periode::factory()->count(5)->create();
    }
}
