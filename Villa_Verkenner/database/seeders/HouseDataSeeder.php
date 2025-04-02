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
        $features = Feature::factory()->count(5)->create();
        $geoOptions = GeoOption::factory()->count(3)->create();

        $houses = House::factory()->count(30)->create();

        foreach ($houses as $house) {
            $randomFeatures = $features->random(rand(1, 3));
            if (!$randomFeatures instanceof Collection) {
                $randomFeatures = collect([$randomFeatures]);
            }
            $house->features()->attach($randomFeatures->pluck('id')->toArray());

            $randomGeoOptions = $geoOptions->random(rand(1, 2));
            if (!$randomGeoOptions instanceof Collection) {
                $randomGeoOptions = collect([$randomGeoOptions]);
            }
            $house->geoOptions()->attach($randomGeoOptions->pluck('id')->toArray());
        }
    }
}