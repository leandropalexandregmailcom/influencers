<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Influencer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User; // Adicionando o modelo User
use Illuminate\Foundation\Testing\RefreshDatabase;

class InfluencerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting the list of influencers.
     *
     * @return void
     */
    public function test_get_all_influencers()
    {
        // Criando um usuário e gerando o token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Influencer::factory()->create([
            'name' => 'John Doe',
            'instagram_handle' => 'john_doe',
            'followers_count' => 10000,
            'category_id' => 1
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, // Passando o token de autenticação
        ])->get('/api/influencers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                        '*' => [
                            'id',
                            'name',
                            'instagram_handle',
                            'followers_count',
                            'category_id',
                            'created_at',
                            'updated_at',
                        ]
                    ]
        ]);
    }

    /**
     * Test creating a new influencer.
     *
     * @return void
     */
    public function test_create_influencer()
    {
        // Criando um usuário e gerando o token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => 'Jane Smith',
            'instagram_handle' => 'jane_smith',
            'followers_count' => 20000,
            'category_id' => 1
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, // Passando o token de autenticação
        ])->postJson('/api/influencers', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'instagram_handle',
                'followers_count',
                'category_id',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    /**
     * Test validation when creating an influencer.
     *
     * @return void
     */
    public function test_create_influencer_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => '',
            'instagram_handle' => 'jane_smith',
            'followers_count' => 20000,
            'category_id' => 1
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/influencers', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }
}
