<?php

namespace Tests\Feature;

use App\Models\Dataset;
use App\Models\Question;
use App\Models\Weight;
use Database\Seeders\QuestionSeeder;
use Database\Seeders\WeightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Random;
use Tests\TestCase;

class DatasetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_random(): void
    {
        $prediction = Random::generate(1, '0-1') == '1' ? 'Addiction' : 'Not addicted';

        Log::info(json_encode($prediction, JSON_PRETTY_PRINT));

        $this->assertNotNull($prediction);
    }

    /**
     * A basic feature test example.
     */
    public function test_seeder(): void
    {

        $this->seed([WeightSeeder::class, QuestionSeeder::class]);

        $dataset = Dataset::create([
            'prediction' => 'Addiction',
        ]);

        for ($i = 1; $i < Question::count() + 1; $i++) {
            $id = Random::generate(1, '1-' . Weight::count());

            $weight = Weight::find($id);
            $question = Question::find($i);

            $dataset->items()->create([
                'weight' => $weight->weight,
                'question_id' => $question->id,
            ]);

            Log::info('id: ' . $id);
            Log::info('weight: ' . json_encode($weight, JSON_PRETTY_PRINT));
            Log::info('question: ' . json_encode($question, JSON_PRETTY_PRINT));
        }

        Log::info(json_encode($dataset->items, JSON_PRETTY_PRINT));

        $this->assertNotNull($dataset);
        $this->assertNotNull($dataset->items);
    }
}
