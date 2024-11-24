<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DictionaryWord;
use App\Models\History;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DictionaryControllerTest extends TestCase
{
    use RefreshDatabase;
    /////  PASS
    public function test_root_route_returns_message()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
    }
    /////  PASS
    public function test_show_returns_word()
    {
        // Configura o banco de dados
        $user = User::factory()->create();
        $word = DictionaryWord::factory()->create();

        // Simula a autenticação
        $this->actingAs($user);

        // Faz a requisição
        $response = $this->getJson("/entries/en/{$word->word}");

        // Valida a resposta
        $response->assertStatus(200)
            ->assertJson([
                'results' => [
                    'word' => $word->word,
                ],
                'totalDocs' => 1,
                'page' => 1,
                'totalPages' => 1,
                'hasNext' => false,
                'hasPrev' => false,
            ]);

        // Valida se a palavra foi salva no histórico
        $this->assertDatabaseHas('history', [
            'user_id' => $user->id,
            'word_id' => $word->id,
        ]);
    }
    /////  PASS
    public function test_show_returns_204_for_non_existent_word()
    {
        // Configura o banco de dados
        $user = User::factory()->create();

        // Simula a autenticação
        $this->actingAs($user);

        // Faz a requisição para uma palavra inexistente
        $response = $this->getJson("/entries/en/nonexistent");

        // Valida a resposta
        $response->assertStatus(204);
    }
    /////  PASS
    public function test_show_returns_401_for_unauthenticated_user()
    {
        // Faz a requisição sem autenticação
        $response = $this->getJson("/entries/en/test");

        // Valida a resposta
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
    ///// FAILED
    public function test_history_returns_user_viewed_words()
    {
        // Configura o banco de dados
        $user = User::factory()->create();
        $word = DictionaryWord::factory()->create();

        // Simula histórico
        $user->history()->create([
            'word_id' => $word->id,
            'viewed_at' => now(),
        ]);

        // Simula a autenticação
        $this->actingAs($user);

        // Faz a requisição
        $response = $this->getJson('/user/me/history');

        // Valida a resposta
        $response->assertStatus(200)
            ->assertJson([
                'results' => [
                    ['word' => $word->word, 'added' => now()->toIso8601String()],
                ],
                'totalDocs' => 1,
                'page' => 1,
                'totalPages' => 1,
                'hasNext' => false,
                'hasPrev' => false,
            ]);
    }
    /////  PASS
    public function test_favorites_returns_user_favorited_words()
    {
        // Configura o banco de dados
        $user = User::factory()->create();
        $word = DictionaryWord::factory()->create();

        // Simula palavras favoritadas
        $user->favorites()->create([
            'word_id' => $word->id,
            'favorited_at' => now(),
        ]);

        // Simula a autenticação
        $this->actingAs($user);

        // Faz a requisição
        $response = $this->getJson('/user/me/favorites');

        // Valida a resposta
        $response->assertStatus(200)
            ->assertJson([
                'results' => [
                    ['word' => $word->word, 'added' => now()->toIso8601String()],
                ],
                'totalDocs' => 1,
                'page' => 1,
                'totalPages' => 1,
                'hasNext' => false,
                'hasPrev' => false,
            ]);
    }
    /////  PASS
    public function test_signup_route_creates_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/auth/signup', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }
    ///// FAILED
    public function test_signin_route_returns_token()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/auth/signin', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'token',  // O token com o prefixo 'Bearer'
            ]);
    }
    ///// FAILED
    public function test_logout_route_logs_user_out()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson('/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out']);
    }
    ///// FAILED
    public function test_index_route_returns_words()
    {
        $response = $this->get('/entries/en');
        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
    ///// FAILED
    public function test_favorite_route_adds_to_favorites()
    {
        $user = User::factory()->create();
        $word = DictionaryWord::factory()->create();

        $response = $this->actingAs($user)
            ->postJson("/entries/en/{$word->word}/favorite");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Word added to favorites']);
    }
    ///// FAILED
    public function test_unfavorite_route_removes_from_favorites()
    {
        $user = User::factory()->create();
        $word = DictionaryWord::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/entries/en/{$word->word}/unfavorite");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Word removed from favorites']);
    }
    /////  PASS
    public function test_profile_route_returns_user_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/user/me');

        $response->assertStatus(200)
            ->assertJson(['name' => $user->name, 'email' => $user->email]);
    }
}
