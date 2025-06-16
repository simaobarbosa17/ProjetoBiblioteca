<?php

use App\Models\User;
use App\Models\Livros;
use App\Models\requesicoes;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('utilizador apenas vê as suas próprias requisições', function () {
    
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $livro1 = Livros::factory()->create();
    $livro2 = Livros::factory()->create();
    $livro3 = Livros::factory()->create();

  
    requesicoes::create([
        'user_id' => $user1->id,
        'livros_id' => $livro1->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(5),
        'estado' => 'ativa',
    ]);

    requesicoes::create([
        'user_id' => $user1->id,
        'livros_id' => $livro2->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(7),
        'estado' => 'ativa',
    ]);

   
    requesicoes::create([
        'user_id' => $user2->id,
        'livros_id' => $livro3->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(6),
        'estado' => 'ativa',
    ]);

 
    requesicoes::create([
        'user_id' => $user3->id,
        'livros_id' => $livro1->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(8),
        'estado' => 'ativa',
    ]);

   
    $response = $this->actingAs($user1)->get(route('verequesicao'));

    
    $response->assertStatus(200);

   
    $requisicoes = requesicoes::where('user_id', $user1->id)->get();
    expect($requisicoes)->toHaveCount(2);

   
    foreach ($requisicoes as $req) {
        expect($req->user_id)->toBe($user1->id);
    }

    $todasRequisicoes = requesicoes::all();
    $requisicoesOutrosUsers = $todasRequisicoes->where('user_id', '!=', $user1->id);

    expect($todasRequisicoes)->toHaveCount(4); 
    expect($requisicoesOutrosUsers)->toHaveCount(2); 
    expect($requisicoes)->toHaveCount(2); 
});
