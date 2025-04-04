<?php

namespace Database\Factories;

use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
{
    protected $model = House::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(1),
            'image'       => $this->faker->imageUrl(),
            'price'       => $this->faker->numberBetween(50000, 500000),
            'address'     => $this->faker->address,
            'status' => $this->faker->randomElement(['Beschikbaar', 'Verkocht']),
            'rooms'       => (string)$this->faker->numberBetween(1, 10),
            'popular' => $this->faker->boolean(),
        ];
    }
}
