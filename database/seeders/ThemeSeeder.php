<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            'Dieu pour tous',
            'Booster vos finances',
            'Investis dès maintenant',
            'Crainte de Dieu',
            'Restauration de l\'âme'
        ];

        foreach ($themes as $theme) {
            Theme::create(['name' => $theme]);
        }
    }
}
