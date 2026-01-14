<?php

namespace Database\Seeders;

use App\Models\CommentaireValeurIndicateur;
use Illuminate\Database\Seeder;

class CommentaireValeurIndicateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommentaireValeurIndicateur::factory()->count(5)->create();
    }
}
