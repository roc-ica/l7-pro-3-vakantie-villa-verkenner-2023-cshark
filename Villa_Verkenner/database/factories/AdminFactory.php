<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'), 
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Create a default admin user.
     */
    public function defaultAdmin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'username' => 'admin',
                'password' => Hash::make('admin123'), 
            ];
        });
    }
}