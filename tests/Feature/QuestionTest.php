<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Question;
use Database\Seeders\UserSeeder;
use Database\Seeders\QuestionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test store question success.
     */
    public function test_store_success(): void
    {
        $this->seed(UserSeeder::class);

        $data = [
            'name' => 'Strongly disagree',
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post('/api/questions', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(201)->assertJson([
            'data' => [
                'id' => 1,
                'name' => 'Strongly disagree',
            ],
            'message' => 'Question created successfully.',
        ]);
    }

    /**
     * A feature test store question failed data_invalidated.
     */
    public function test_store_failed_data_invalidated(): void
    {
        $this->seed(UserSeeder::class);

        $data = [];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post('/api/questions', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(400)->assertJson([
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
            ]
        ]);
    }

    /**
     * A feature test store question failed not authorized.
     */
    public function test_store_failed_not_authorized(): void
    {
        $this->seed([QuestionSeeder::class]);

        $data = [
            'name' => 'Strongly disagree',
        ];

        $response = $this->post('/api/questions', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.',
            ],
        ]);
    }

    /**
     * A feature test show question success.
     */
    public function test_show_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $response = $this->get('/api/questions');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(10, count($response->json(['data'])));
    }

    /**
     * A feature test show question filter success.
     */
    public function test_show_filter_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $response = $this->get('/api/questions?limit=5&name=smartphone');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(5, count($response->json(['data'])));
    }

    /**
     * A feature test get question success.
     */
    public function test_get_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $question = Question::query()->limit(1)->first();

        $response = $this->get('/api/questions/' . $question->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $question->id,
                'name' => $question->name,
            ]
        ]);
    }

    /**
     * A feature test get question failed.
     */
    public function test_get_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $response = $this->get('/api/questions/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Question not found.'
            ]
        ]);
    }

    /**
     * A feature test update question success.
     */
    public function test_update_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $question = Question::query()->limit(1)->first();

        $data = [
            'name' => 'Strongly disagree updated',
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/questions/' . $question->id, $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Strongly disagree updated',
            ],
            'message' => 'Question updated successfully.',
        ]);
    }

    /**
     * A feature test update question failed.
     */
    public function test_update_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $data = [
            'name' => 'Strongly disagree updated',
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/questions/1', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Question not found.'
            ]
        ]);
    }

    /**
     * A feature test update question failed data_invalidated.
     */
    public function test_update_failed_data_invalidated(): void
    {
        $this->seed([UserSeeder::class]);

        $data = [];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/questions/1', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(400)->assertJson([
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
            ]
        ]);
    }

    /**
     * A feature test update question failed.
     */
    public function test_update_failed_not_authorized(): void
    {
        $this->seed([QuestionSeeder::class]);

        $question = Question::query()->limit(1)->first();

        $data = [
            'name' => 'Strongly disagree updated',
        ];

        $response = $this->put('/api/questions/' . $question->id, $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.',
            ],
        ]);
    }

    /**
     * A feature test delete question success.
     */
    public function test_delete_success(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $question = Question::query()->limit(1)->first();

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/questions/' . $question->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'message' => 'Question deleted successfully.',
        ]);
    }

    /**
     * A feature test delete question failed.
     */
    public function test_delete_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/questions/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Question not found.'
            ]
        ]);
    }

    /**
     * A feature test delete question failed not authorized.
     */
    public function test_delete_failed_not_authorized(): void
    {
        $this->seed([UserSeeder::class, QuestionSeeder::class]);

        $question = Question::query()->limit(1)->first();

        $response = $this->delete('/api/questions/' . $question->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.'
            ]
        ]);
    }
}
