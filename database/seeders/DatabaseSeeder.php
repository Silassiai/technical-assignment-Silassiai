<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Dimitri',
            'email' => getenv('REVIEWER_EMAIL'),
            'password' => Hash::make(getenv('REVIEWER_PASSWORD')),
        ]);
    }
}
