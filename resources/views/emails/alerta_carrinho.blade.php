<x-mail::message>
# Olá {{ $user->name }},

Notamos que você deixou alguns livros no seu carrinho. Precisa de ajuda para finalizar a compra?

<x-mail::panel>
<ul style="list-style-type: none; padding-left: 0;">
@foreach($itens as $item)
    <li>
        <strong>{{ $item->livro->nome }}</strong> – {{ number_format($item->livro->preco, 2) }}€
    </li>
@endforeach
</ul>
</x-mail::panel>

<x-mail::button :url="route('vercarrinho')">
Voltar ao carrinho
</x-mail::button>

</x-mail::message>