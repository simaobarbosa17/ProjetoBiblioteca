<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/3 p-6 flex justify-center items-start">
                    <div class="text-center">
                        <img src="{{ asset($livro->capa) }}" alt="Capa do livro {{ $livro->nome }}"
                            class="w-64 h-80 object-cover shadow-lg rounded-lg border-2 border-gray-200 mx-auto">

                       
                    </div>
                </div>

                <div class="md:w-2/3 p-6">
                    <div class="space-y-4">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">{{ $livro->nome }}</h1>
                            <div class="flex items-center space-x-4 text-sm">
                                <span>ISBN: {{ $livro->isbn }}</span>
                                <span>•</span>
                                <span>{{ $livro->editora->nome }}</span>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wide">Autores</h3>
                            <div class="mt-1 flex flex-wrap gap-2">
                                @foreach ($livro->autores as $autor)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $autor->nome }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wide">Descrição</h3>
                            <p class="mt-2 leading-relaxed">{{ $livro->bibliografia }}</p>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-3xl font-bold">€{{ number_format($livro->preco, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class= p-6 shadow rounded mb-8">
            <h3 class="text-lg font-semibold mb-4">Requisições deste Livro</h3>

            @if ($livro->requesicoes->isEmpty())
                <p class="">Nenhuma requisição feita ainda.</p>
            @else
                <table class="table w-full">
                    <thead>
                        <tr class="">
                            <th class="text-left p-2">Usuário</th>
                            <th class="text-left p-2">Data de Requisição</th>
                            <th class="text-left p-2">Data de Entrega</th>
                            <th class="text-left p-2">Data Devolvida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($livro->requesicoes as $requisicao)
                            <tr class="border-b">
                                <td class="p-2">{{ $requisicao->user->name }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</td>
                                <td class="p-2">
                                    {{ $requisicao->data_devolvida ? \Carbon\Carbon::parse($requisicao->data_devolvida)->format('d/m/Y') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($relacionados->isNotEmpty())
            <div class="shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    Livros Relacionados
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relacionados as $livroRel)
                        <div class="rounded-lg p-4 hover:shadow-md transition duration-200">
                            <h4 class="font-bold mb-2">{{ $livroRel->nome }}</h4>
                            <p class="text-sm mb-3 leading-relaxed">{{ Str::limit($livroRel->bibliografia, 100) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold">€{{ number_format($livroRel->preco, 2) }}</span>
                                <a href="{{ route('detalhelivro.show', $livroRel->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-black text-sm font-medium py-2 px-4 rounded transition duration-200">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
