<?php

use App\Models\User;

it('returns token after successful login', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['token']);
});

it('allows access to breweries list with valid token', function () {
    // Creo un utente di test
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    // Effettuo login per ottenere il token
    $loginResponse = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $loginResponse->assertOk();
    $token = $loginResponse->json('token');

    // Effettuo la chiamata all’endpoint protetto con il token nell’header Authorization
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('/api/breweries');

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);
});
