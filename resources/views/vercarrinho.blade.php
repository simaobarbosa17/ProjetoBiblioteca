<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrinho de Compras</h2>
            <div class="text-sm text-gray-600">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    {{ count($carrinho) }} {{ count($carrinho) == 1 ? 'livro' : 'livros' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(count($carrinho) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ count($carrinho) }}</div>
                            <div class="text-sm text-gray-500">Livro(s)</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-600">
                                €{{ number_format($carrinho->sum(fn($item) => $item->livro->preco * $item->quantidade), 2, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                        <div>
                            <a href="{{ route('carrinho.finalizar') }}" 
                            class="bg-blue-600 hover:bg-blue-700 text-black font-medium py-2 px-6 rounded-lg transition-colors inline-block">
                                Finalizar Compra
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livro</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalhes</th>
                                    <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                    <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                      <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($carrinho as $item)
                                    <tr class="transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="flex items-start space-x-4">
                                                <img src="{{ asset($item->livro->capa) }}" 
                                                     alt="Capa do livro {{ $item->livro->nome }}"
                                                     class="h-32 w-16 object-cover rounded shadow-sm border border-gray-200">
                                            </div>
                                        </td>

                                       <td class="py-4 px-4 align-top max-w-2xl">
                                            <div class="flex flex-col gap-2 text-sm text-gray-700 leading-relaxed">
                                                  <div class="flex-1">
                                                        <h3 class="text-sm font-semibold text-gray-900 leading-snug">{{ $item->livro->nome }} </h3>
                                                  </div>
                                                <div>
                                                    <p class="text-gray-600 line-clamp-4">
                                                    {{ Str::limit(strip_tags($item->livro->bibliografia), 400, '...') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <form method="POST" action="{{ route('carrinho.atualizar', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1" class="w-16 text-center border rounded">
                                                <button type="submit" class="ml-2 text-blue-600 hover:underline text-sm">Atualizar</button>
                                            </form>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="text-lg font-semibold text-gray-900">
                                                €{{ number_format($item->livro->preco, 2, ',', '.') }}
                                            </div>
                                        </td>

                                        <td class="py-4 px-4 text-center">
                                            <form method="POST" action="{{ route('carrinho.remover', $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-500 hover:underline text-sm">Remover</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-ms shadow-sm border border-gray-200 p-12 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Seu carrinho está vazio</h3>
                    <p class="text-gray-500 mb-6">Adicione alguns livros ao seu carrinho para começar.</p>
                    <a href="{{ route('dashboard') }}">
                        <button class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-2 rounded-lg font-medium transition-colors">
                            Explorar Livros
                        </button>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
