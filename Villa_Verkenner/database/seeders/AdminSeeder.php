<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin account
        Admin::factory()->defaultAdmin()->create();
        
        // Uncomment the following line if you want to create additional random admin accounts
        // Admin::factory()->count(3)->create();
    }
}