<x-mail::message>
# Novo Pedido Recebido

📌 Um novo pedido foi realizado no sistema.

**Cliente:** {{ $encomenda->user->name }}  
**Email:** {{ $encomenda->user->email }}  
**ID do Pedido:** #{{ $encomenda->id }}  
**Data:** {{ $encomenda->created_at->format('d/m/Y H:i') }}

<x-mail::table>
| Livro         | Quantidade | Preço      |
| ------------- | ---------- | ---------- |
@foreach ($encomenda->livros as $livro)
| {{ $livro->nome }} | {{ $livro->pivot->quantidade ?? 1 }} | € {{ number_format($livro->preco, 2, ',', '.') }} |
@endforeach
</x-mail::table>



<x-mail::button :url="route('admin.todasencomendas')">
Ver Pedido no Painel
</x-mail::button>


</x-mail::message>