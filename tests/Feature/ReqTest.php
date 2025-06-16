<?php
use App\Models\User;
use App\Models\Livros;
use App\Models\requesicoes;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

test('Criação de Requisição de Livro', function () {
    $livro = Livros::factory()->create();
    $user = User::factory()->create();

    $requisicao = requesicoes::create([
        'user_id' => $user->id,
        'livros_id' => $livro->id,
        'data_requisicao' => now(),
        'data_entrega' => now()->addDays(5),
    ]);
    expect($requisicao)->toBeInstanceOf(Requesicoes::class);
    expect($requisicao->user_id)->toBe($user->id);
    expect($requisicao->livros_id)->toBe($livro->id);
    expect($requisicao->exists)->toBeTrue();

    $this->assertDatabaseHas('requesicoes', [
        'user_id' => $user->id,
        'livros_id' => $livro->id,
    ]);
});