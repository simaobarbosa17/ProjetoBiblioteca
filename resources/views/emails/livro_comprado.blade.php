<x-mail::message>
# Pedido Confirmado 📚

Olá {{ $encomenda->user->name }},

Obrigado pela sua compra! Aqui estão os detalhes do seu pedido:

<x-mail::table>
| Livro         | Quantidade | Preço      |
| ------------- | ---------- | ---------- |
@foreach ($encomenda->livros as $livro)
| {{ $livro->nome }} | {{ $livro->pivot->quantidade ?? 1 }} | € {{ number_format($livro->preco, 2, ',', '.') }} |
@endforeach
</x-mail::table>



<x-mail::button :url="route('dashboard')">
Acessar minha conta
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}



</x-mail::message>