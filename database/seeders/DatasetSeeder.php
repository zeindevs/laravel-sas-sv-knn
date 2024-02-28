<?php

namespace Database\Seeders;

use App\Models\Dataset;
use App\Models\Question;
use App\Models\Weight;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($d = 1; $d < 10; $d++) {
            $prediction = Random::generate(1, '0-1') == "1" ? "Addiction" : "Not Addiction";

            $dataset = Dataset::create([
                'prediction' => $prediction,
            ]);

            for ($i = 1; $i < Question::count() + 1; $i++) {
                $id = Random::generate(1, '1-' . Weight::count());

                $weight = Weight::find($id);
                $question = Question::find($i);

                $dataset->items()->create([
                    'weight' => $weight->weight,
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}
