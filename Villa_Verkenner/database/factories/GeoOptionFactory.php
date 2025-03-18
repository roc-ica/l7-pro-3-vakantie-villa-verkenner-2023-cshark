<?php

namespace Database\Factories;

use App\Models\GeoOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeoOptionFactory extends Factory
{
    protected $model = GeoOption::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
        ];
    }
}