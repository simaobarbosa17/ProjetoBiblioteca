<?php

use App\Models\Editoras;
use App\Models\Livros;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('não requisitar livro sem stock', function () {
    $editora = Editoras::factory()->create();

    $livro = Livros::create([
        'isbn' => '1234567890',
        'nome' => 'Livro Sem Stock',
        'editora_id' => $editora->id,
        'bibliografia' => 'Texto de exemplo',
        'capa' => 'capa.jpg',
        'preco' => 50.00,
        'stock' => 0,
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('requisicoes.store'), [
            'livros_id' => $livro->id,
            'data_requisicao' => now()->toDateString(),
            'data_entrega' => now()->addDays(7)->toDateString(),
        ])
       ->assertSessionHas('error', 'Este livro não tem stock disponível para requisição.');

});