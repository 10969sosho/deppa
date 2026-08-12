<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NameAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_unique_player_and_returns_a_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'nama' => 'Budi Santoso',
            'usia' => 12,
            'jenjang' => 'SD',
            'gender' => 'L',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.player.name', 'Budi Santoso')
            ->assertJsonPath('data.user.name', 'Budi Santoso')
            ->assertJsonStructure(['data' => ['token', 'player' => ['id', 'name']]]);

        $this->assertDatabaseHas('players', ['nama' => 'Budi Santoso']);

        $this->postJson('/api/auth/register', [
            'nama' => 'budi santoso',
            'usia' => 13,
            'jenjang' => 'SMP',
            'gender' => 'L',
        ])->assertUnprocessable();
    }

    public function test_player_can_login_with_name_only(): void
    {
        $registration = $this->postJson('/api/player', [
            'nama' => 'Siti Aminah',
            'usia' => 11,
            'jenjang' => 'SD',
            'gender' => 'P',
        ])->assertCreated();

        $this->postJson('/api/auth/login', ['nama' => 'siti aminah'])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.player.name', 'Siti Aminah')
            ->assertJsonStructure(['data' => ['token']]);

        $this->assertNotEmpty($registration->json('data.token'));
    }

    public function test_finish_and_downloads_use_the_player_name(): void
    {
        $registration = $this->postJson('/api/auth/register', [
            'nama' => 'Dewi Lestari',
            'usia' => 14,
            'jenjang' => 'SMP',
            'gender' => 'P',
        ])->assertCreated();

        $token = $registration->json('data.token');

        $this->withToken($token)
            ->putJson('/api/player/Dewi%20Lestari/finish', ['score' => 95])
            ->assertOk();

        $this->withToken($token)
            ->get('/api/player/Dewi%20Lestari/report')
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename=laporan-game-dewi-lestari.pdf');

        $this->withToken($token)
            ->get('/api/player/Dewi%20Lestari/certificate')
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename=sertifikat-dewi-lestari.pdf');
    }

    public function test_google_auth_route_is_not_available(): void
    {
        $this->postJson('/api/auth/google', ['id_token' => 'unused'])
            ->assertStatus(405);
    }
}
