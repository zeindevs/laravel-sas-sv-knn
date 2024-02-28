<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PredictionTest extends TestCase
{
    /**
     * A feature test prediction.
     */
    public function test_prediction(): void
    {
        $response = $this->get('/api/predicts');

        Log::info('prediction: ' . json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);
    }

    /**
     * A feature test prediction dataset.
     */
    public function test_dataset(): void
    {
        $response = $this->get('/api/predicts/datasets');

        Log::info('prediction: ' . json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);
    }
}
