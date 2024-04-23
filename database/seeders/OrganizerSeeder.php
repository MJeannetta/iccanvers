<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organizer;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizers = [
            'Dominique', 
            'Jeannetta', 
            'Audrey', 
            'Anne-Céline', 
            'Hugues', 
            'Simone'
        ];

        foreach ($organizers as $organizer) {
            Organizer::create(['name' => $organizer]);
        }
    }
}
