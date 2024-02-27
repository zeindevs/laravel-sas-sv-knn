<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'name' => "Missing planned work due to smartphone use",
        ]);
        Question::create([
            'name' => "Having a hard time concentrating in class, while doing assignments, or while working due to smartphone use",
        ]);
        Question::create([
            'name' => "Feeling pain in the wrists or at the back of the neck while using a smartphone",
        ]);
        Question::create([
            'name' => "Won't be able to stand not having a smartphone",
        ]);
        Question::create([
            'name' => "Feeling impatient and fretful when I am not holding my smartphone",
        ]);
        Question::create([
            'name' => "Having my smartphone in my mind even when I am not using it",
        ]);
        Question::create([
            'name' => "I will never give up using my smartphone even when my daily life is already greatly affected by it.",
        ]);
        Question::create([
            'name' => "Constantly checking my smartphone so as not to miss conversations between other people on Twitter or Facebook",
        ]);
        Question::create([
            'name' => "Using my smartphone longer than I had intended",
        ]);
        Question::create([
            'name' => "The people around me tell me that I use my smartphone too much.",
        ]);
    }
}
