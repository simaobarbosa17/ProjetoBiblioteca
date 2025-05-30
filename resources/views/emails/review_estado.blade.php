<x-mail::message>
# Estado da sua Review

Olá {{ $review->user->name }},

A sua avaliação do livro **{{ $review->livro->nome }}** foi analisada.

@if ($aprovada)
✅ **A sua review foi aprovada!**  
Ela agora está visível na página do livro para outros utilizadores.

@else
❌ **A sua review foi recusada.**  
Motivo da recusa:

> {{ $review->justificacao }}

@endIf

<x-mail::button :url="route('detalhelivro.show', $review->livro)">
Ver Livro
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>