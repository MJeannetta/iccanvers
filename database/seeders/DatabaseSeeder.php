<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrganizerSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\ThemeSeeder;
use Database\Seeders\RoleSeeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //APPEL DES SEEDERS POUR ÉXÉCUTER CETTE FONCTION
        $this->call([
            OrganizerSeeder::class,
            LocationSeeder::class,
            ThemeSeeder::class,
            MinistrySeeder::class,
            RoleSeeder::class,
        ]);

        // Utilisation de la factory pour créer 15 utilisateurs
        User::factory()->count(15)->create();
    }
}
