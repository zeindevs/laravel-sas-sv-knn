<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Weight;
use Database\Seeders\UserSeeder;
use Database\Seeders\WeightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WeightTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test store weight success.
     */
    public function test_store_success(): void
    {
        $this->seed(UserSeeder::class);

        $data = [
            'name' => 'Strongly disagree',
            'weight' => 1,
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post('/api/weights', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(201)->assertJson([
            'data' => [
                'id' => 1,
                'name' => 'Strongly disagree',
                'weight' => 1,
            ],
            'message' => 'Weight created successfully.',
        ]);
    }

    /**
     * A feature test store weight failed data_invalidated.
     */
    public function test_store_failed_data_invalidated(): void
    {
        $this->seed(UserSeeder::class);

        $data = [];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post('/api/weights', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(400)->assertJson([
            'errors' => [
                'name' => [
                    'The name field is required.'
                ],
                'weight' => [
                    'The weight field is required.'
                ]
            ]
        ]);
    }

    /**
     * A feature test store weight failed not authorized.
     */
    public function test_store_failed_not_authorized(): void
    {
        $this->seed([WeightSeeder::class]);

        $data = [
            'name' => 'Strongly disagree',
            'weight' => 1,
        ];

        $response = $this->post('/api/weights', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.',
            ],
        ]);
    }

    /**
     * A feature test show weight success.
     */
    public function test_show_success(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $response = $this->get('/api/weights');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(6, count($response->json(['data'])));
    }

    /**
     * A feature test show weight filter success.
     */
    public function test_show_filter_success(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $response = $this->get('/api/weights?limit=5&name=Strongly');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200);

        $this->assertEquals(2, count($response->json(['data'])));
    }

    /**
     * A feature test get weight success.
     */
    public function test_get_success(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $weight = Weight::query()->limit(1)->first();

        $response = $this->get('/api/weights/' . $weight->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $weight->id,
                'name' => $weight->name,
                'weight' => $weight->weight,
            ]
        ]);
    }

    /**
     * A feature test get weight failed.
     */
    public function test_get_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $response = $this->get('/api/weights/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Weight not found.'
            ]
        ]);
    }

    /**
     * A feature test list weight.
     */
    public function test_list_weight(): void
    {
        $this->seed([WeightSeeder::class]);

        $weights = Weight::select('weight')->whereIn('id', [1, 2, 3, 4, 5, 6])->get();

        $answers = [];

        foreach ($weights as $item) {
            array_push($answers, $item['weight']);
        };

        Log::info(json_encode($answers, JSON_PRETTY_PRINT));

        $this->assertEquals(6, count($answers));
    }

    /**
     * A feature test update weight success.
     */
    public function test_update_success(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $weight = Weight::query()->limit(1)->first();

        $data = [
            'name' => 'Strongly disagree updated',
            'weight' => 2,
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/weights/' . $weight->id, $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Strongly disagree updated',
                'weight' => 2,
            ],
            'message' => 'Weight updated successfully.',
        ]);
    }

    /**
     * A feature test update weight failed.
     */
    public function test_update_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $data = [
            'name' => 'Strongly disagree updated',
            'weight' => 2,
        ];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/weights/1', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Weight not found.'
            ]
        ]);
    }

    /**
     * A feature test update weight failed data_invalidated.
     */
    public function test_update_failed_data_invalidated(): void
    {
        $this->seed([UserSeeder::class]);

        $data = [];

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->put('/api/weights/1', $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(400)->assertJson([
            'errors' => [
                'name' => [
                    'The name field is required.'
                ],
                'weight' => [
                    'The weight field is required.'
                ]
            ]
        ]);
    }

    /**
     * A feature test update weight failed.
     */
    public function test_update_failed_not_authorized(): void
    {
        $this->seed([WeightSeeder::class]);

        $weight = Weight::query()->limit(1)->first();

        $data = [
            'name' => 'Strongly disagree updated',
            'weight' => 2,
        ];

        $response = $this->put('/api/weights/' . $weight->id, $data);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.',
            ],
        ]);
    }

    /**
     * A feature test delete weight success.
     */
    public function test_delete_success(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $weight = Weight::query()->limit(1)->first();

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/weights/' . $weight->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(200)->assertJson([
            'message' => 'Weight deleted successfully.',
        ]);
    }

    /**
     * A feature test delete weight failed.
     */
    public function test_delete_failed(): void
    {
        $this->seed([UserSeeder::class]);

        $user = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($user)->delete('/api/weights/1');

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'message' => 'Weight not found.'
            ]
        ]);
    }

    /**
     * A feature test delete weight failed not authorized.
     */
    public function test_delete_failed_not_authorized(): void
    {
        $this->seed([UserSeeder::class, WeightSeeder::class]);

        $weight = Weight::query()->limit(1)->first();

        $response = $this->delete('/api/weights/' . $weight->id);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        $response->assertStatus(401)->assertJson([
            'errors' => [
                'message' => 'Unauthorized.'
            ]
        ]);
    }
}
