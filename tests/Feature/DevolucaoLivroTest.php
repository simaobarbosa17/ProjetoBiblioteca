<?php

use App\Models\User;
use App\Models\Livros;
use App\Models\requesicoes;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário pode devolver um livro e estado é atualizado', function () {
  
    $user = User::factory()->create();
    $livro = Livros::factory()->create();

   
    $requisicao = requesicoes::create([
        'user_id' => $user->id,
        'livros_id' => $livro->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(7),
        'estado' => 'ativa',
    ]);

  
    $this->actingAs($user);

   
    $response = $this->patch(route('requisicoes.devolver', $requisicao->id));

  
    $response->assertRedirect();

    
    $this->assertDatabaseHas('requesicoes', [
        'id' => $requisicao->id,
        'estado' => 'devolvida',
    ]);
});