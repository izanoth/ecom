<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\Customer::factory(10)->create();
        /*
        * User Factory
        */
        \App\Models\User::factory(10)->create();
        /*
        * Product Factory ***** NEED FIX
        */
        \App\Models\Product::factory(50)->create();
        /*
        * Shipping Factory
        */
        //\App\Models\Shipping::factory(50)->create();
        
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
