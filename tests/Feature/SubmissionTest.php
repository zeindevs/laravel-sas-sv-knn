<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use App\Models\Weight;
use Database\Seeders\DatasetSeeder;
use Database\Seeders\QuestionSeeder;
use Database\Seeders\SubmissionSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WeightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test store submission success.
     */
    public function test_store_submission_success(): void
    {
        $this->seed([QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class]);

        $data = [
            'name' => 'Sayuri Hokakaido',
            'questions' => [
                [
                    'id' => 1,
                    'answer' => 5
                ],
                [
                    'id' => 2,
                    'answer' => 5
                ],
                [
                    'id' => 3,
                    'answer' => 5
                ],
                [
                    'id' => 4,
                    'answer' => 5
                ],
                [
                    'id' => 5,
                    'answer' => 5
                ],
                [
                    'id' => 6,
                    'answer' => 5
                ],
                [
                    'id' => 7,
                    'answer' => 5
                ],
                [
                    'id' => 8,
                    'answer' => 5
                ],
                [
                    'id' => 9,
                    'answer' => 5
                ],
                [
                    'id' => 10,
                    'answer' => 5
                ]
            ]
        ];

        $response = $this->post('/api/submissions', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(201);
    }

    /**
     * A feature test show submission success.
     */
    public function test_show_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->get('/api/submissions');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json(['data'])));
    }

    /**
     * A feature test show submission failed not auhorized.
     */
    public function test_show_failed_not_authorized(): void
    {
        $this->seed([QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $response = $this->get('/api/submissions');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.'
            ]
        ]);
    }

    /**
     * A feature test show submission filter success.
     */
    public function test_show_filter_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->get('/api/submissions?limit=5&name=Sayuri');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json(['data'])));
    }

    /**
     * A feature test show submission filter failed not authorized.
     */
    public function test_show_filter_failed_not_authorized(): void
    {
        $this->seed([QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $response = $this->get('/api/submissions?limit=5&name=Sayuri');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.'
            ]
        ]);
    }

    /**
     * A feature test get submission success.
     */
    public function test_get_success(): void
    {
        $this->seed([QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $submission = Submission::query()->limit(1)->first();

        $response = $this->get('/api/submissions/' . $submission->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $submission->id,
                'name' => $submission->name,
                'prediction' => $submission->prediction,
            ]
        ]);
    }

    /**
     * A feature test get submission failed.
     */
    public function test_get_failed(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class]);

        $response = $this->get('/api/submissions/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Submission not found.'
            ]
        ]);
    }

    /**
     * A feature test store submission failed.
     */
    public function test_store_submission_failed(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $data = [];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post('/api/submissions', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(400);
    }

    /**
     * A feature test delete submission success.
     */
    public function test_delete_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $submission = Submission::query()->limit(1)->first();

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/submissions/' . $submission->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'message' => 'Submission deleted successfully.',
        ]);
    }

    /**
     * A feature test delete submission failed.
     */
    public function test_delete_failed(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class]);

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/submissions/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Submission not found.'
            ]
        ]);
    }

    /**
     * A feature test delete submission failed not authorized.
     */
    public function test_delete_failed_not_authorized(): void
    {
        $this->seed([QuestionSeeder::class, WeightSeeder::class, DatasetSeeder::class, SubmissionSeeder::class]);

        $submission = Submission::query()->limit(1)->first();

        $response = $this->delete('/api/submissions/' . $submission->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.'
            ]
        ]);
    }
}
