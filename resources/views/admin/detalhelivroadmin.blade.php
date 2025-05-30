<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhe Livro: {{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-6">
        <div class="bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold mb-4">Informações do Livro</h3>
            <p><strong>ISBN:</strong> {{ $livro->isbn }}</p>
            <p><strong>Editora:</strong> {{ $livro->editora->nome }}</p>
            <p><strong>Autores</strong> 
                @foreach ($livro->autores as $autor)
                 {{ $autor->nome }},
                 @endforeach</p>
            <p><strong>Bibliografia:</strong> {{ $livro->bibliografia }}</p>
            <p><strong>Preço:</strong> €{{ $livro->preco }}</p>
            <p><strong>Autores</strong></p>
            <div class="mt-3">
              <img src="{{ asset($livro->capa) }}" 
                    alt="Capa do livro" width="200" height="240"
                    class="object-contain shadow-sm border border-gray-200">
            </div>
        </div>

        <div class="bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold mb-4">Requisições deste Livro</h3>

            @if ($livro->requesicoes->isEmpty())
                <p class="text-gray-500">Nenhuma requisição feita ainda.</p>
            @else
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2">Usuário</th>
                            <th class="text-left p-2">Data de Requisição</th>
                            <th class="text-left p-2">Data de Entrega</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($livro->requesicoes as $requisicao)
                            <tr class="border-b">
                                <td class="p-2">{{ $requisicao->user->name }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>

