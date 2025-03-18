<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;

class HouseDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 features and 3 geo options
        $features = Feature::factory()->count(5)->create();
        $geoOptions = GeoOption::factory()->count(3)->create();

        // Create 10 houses
        $houses = House::factory()->count(10)->create();

        // For each house attach random features and geo options
        foreach ($houses as $house) {
            // Attach 1 to 3 random features
            $house->features()->attach(
                $features->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Attach 1 to 2 random geo options
            $house->geoOptions()->attach(
                $geoOptions->random(rand(1, 2))->pluck('id')->toArray()
            );
        }
    }
}