<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ministry;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ministries = [
            'IMPACT CÉLÉBRATION', 
            'IMPACT JUNIOR', 
            'INTERCESSION', 
        ];

        foreach ($ministries as $ministry) {
            Ministry::create(['name' => $ministry]);
        }
    }
}
