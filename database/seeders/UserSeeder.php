<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin2024'),
            'email_verified_at' => Carbon::now(),
        ]);
        User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('guest2024'),
        ]);
    }
}
