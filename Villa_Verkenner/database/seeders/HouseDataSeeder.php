<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Support\Collection;

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
            // Randomly select 1 to 3 features
            $randomFeatures = $features->random(rand(1, 3));
            // Ensure we have a Collection even for a single result
            if (!$randomFeatures instanceof Collection) {
                $randomFeatures = collect([$randomFeatures]);
            }
            $house->features()->attach($randomFeatures->pluck('id')->toArray());

            // Randomly select 1 to 2 geo options
            $randomGeoOptions = $geoOptions->random(rand(1, 2));
            // Ensure we have a Collection even for a single result
            if (!$randomGeoOptions instanceof Collection) {
                $randomGeoOptions = collect([$randomGeoOptions]);
            }
            $house->geoOptions()->attach($randomGeoOptions->pluck('id')->toArray());
        }
    }
}