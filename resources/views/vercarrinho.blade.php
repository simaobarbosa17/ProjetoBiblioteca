<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-base-content flex items-center gap-2">Carrinho de Compras</h2>
            <div class="badge badge-info text-sm">
                {{ count($carrinho) }} {{ count($carrinho) === 1 ? 'livro' : 'livros' }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(count($carrinho) > 0)
                <section class="bg-base-100 rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-3xl font-bold">{{ count($carrinho) }}</div>
                            <div class="text-sm">Livro{{ count($carrinho) > 1 ? 's' : '' }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">
                                €{{ number_format($carrinho->sum(fn($item) => $item->livro->preco * $item->quantidade), 2, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                        <div>
                            <a href="{{ route('carrinho.finalizar') }}" class="btn btn-primary w-full md:w-auto" role="button" aria-label="Finalizar compra">
                                Finalizar Compra
                            </a>
                        </div>
                    </div>
                </section>

                <section class="overflow-x-auto bg-base-100 rounded-lg shadow-md">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th scope="col">Livro</th>
                                <th scope="col">Detalhes</th>
                                <th scope="col" class="text-center">Quantidade</th>
                                <th scope="col" class="text-center">Preço</th>
                                <th scope="col" class="sr-only">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carrinho as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset($item->livro->capa) }}" 
                                             alt="Capa do livro {{ $item->livro->nome }}"
                                             class="h-20 w-12 object-cover rounded shadow" />
                                    </td>

                                    <td class="max-w-xs">
                                        <h3 class="font-semibold">{{ $item->livro->nome }}</h3>
                                        <p class="text-sm text-gray-600 line-clamp-4">
                                            {{ Str::limit(strip_tags($item->livro->bibliografia), 400, '...') }}
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <form method="POST" action="{{ route('carrinho.atualizar', $item->id) }}" class="flex flex-col items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1" class="input input-sm input-bordered w-20 text-center" aria-label="Quantidade do livro {{ $item->livro->nome }}" />
                                            <button type="submit" class="link link-primary text-sm">Atualizar</button>
                                        </form>
                                    </td>

                                    <td class="text-center text-lg font-semibold">
                                        €{{ number_format($item->livro->preco, 2, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        <form method="POST" action="{{ route('carrinho.remover', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="link link-error hover:underline text-sm" aria-label="Remover {{ $item->livro->nome }} do carrinho">
                                                Remover
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

            @else
                <section class="bg-base-100 rounded-lg shadow-md p-12 text-center">
                    <h3 class="text-xl font-semibold  mb-4">Seu carrinho está vazio</h3>
                    <p class= mb-6">Adicione alguns livros ao seu carrinho para começar.</p>
                    <a href="{{ route('dashboard') }}">
                        <button class="btn btn-primary px-8 py-3 font-medium transition-colors" role="button" aria-label="Explorar Livros">
                            Explorar Livros
                        </button>
                    </a>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>