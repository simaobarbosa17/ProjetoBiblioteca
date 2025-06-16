<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Validação de Requisição', function () {
   
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/requisicoes', [
        'user_id' => $user->id,
        'livros_id' => 9999, 
    ]);
    $response->assertStatus(422); 
    $response->assertJsonValidationErrors('livros_id');
});