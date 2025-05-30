<x-mail::message>
# 📚 O livro "{{ $livro->nome }}" está novamente disponível!

Agora podes requisitá-lo.

<x-mail::button :url="route('detalhelivro.show', $livro->id)">
Ver Livro
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
