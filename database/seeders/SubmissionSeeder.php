<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Submission;
use App\Models\Weight;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prediction = Random::generate(1, '0-1') == "1" ? "Addiction" : "Non addicted";

        $submission = Submission::create([
            'name' => "Sayuri Hokkaido",
            'prediction' => $prediction,
        ]);

        for ($i = 1; $i < Question::count() + 1; $i++) {
            $id = Random::generate(1, '1-' . Weight::count());

            $weight = Weight::find($id);
            $question = Question::find($i);

            $submission->items()->create([
                'weight_id' => $weight->id,
                'question_id' => $question->id,
            ]);
        }
    }
}
