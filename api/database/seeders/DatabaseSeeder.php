<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // 1. Validate if user created
        \App\Models\User::factory(1)->create(
            [
                'name' => 'Admin Owner',
                'email' => 'admin@admin.com',
                'email_verified_at' => null,
            ]
        );
    }
}
