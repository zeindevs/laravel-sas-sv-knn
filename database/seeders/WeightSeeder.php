<?php

namespace Database\Seeders;

use App\Models\Weight;
use Illuminate\Database\Seeder;

class WeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weight::create([
            'name' => 'Strongly disagree',
            'weight' => 1,
        ]);
        Weight::create([
            'name' => 'Disagree',
            'weight' => 2,
        ]);
        Weight::create([
            'name' => 'Weakly disagree',
            'weight' => 3,
        ]);
        Weight::create([
            'name' => 'Weakly agree',
            'weight' => 4,
        ]);
        Weight::create([
            'name' => 'Agree',
            'weight' => 5,
        ]);
        Weight::create([
            'name' => 'Strongly agree',
            'weight' => 6,
        ]);
    }
}
