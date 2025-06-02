<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="md:flex">
                
                <div class="md:w-1/3 p-6 bg-gray-50 flex justify-center items-start">
                    <div class="text-center">
                        <img src="{{ asset($livro->capa) }}" alt="Capa do livro {{ $livro->nome }}"
                            class="w-64 h-80 object-cover shadow-lg rounded-lg border-2 border-gray-200 mx-auto">

                        <div class="mt-4">
                            @if($livro->disponivel)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    ✅ Disponível
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    ❌ Indisponível
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                
                <div class="md:w-2/3 p-6">
                    <div class="space-y-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $livro->nome }}</h1>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>ISBN: {{ $livro->isbn }}</span>
                                <span>•</span>
                                <span>{{ $livro->editora->nome }}</span>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Autores</h3>
                            <div class="mt-1 flex flex-wrap gap-2">
                                @foreach ($livro->autores as $autor)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $autor->nome }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Descrição</h3>
                            <p class="mt-2 text-gray-600 leading-relaxed">{{ $livro->bibliografia }}</p>
                        </div>

                        
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-3xl font-bold text-gray-900">€{{ number_format($livro->preco, 2) }}</span>
                                </div>

                                <div class="flex space-x-3">
                                    @if($livro->disponivel)
                                        @if (!$nocarrinho)
                                            <form method="POST" action="{{ route('adicionarcarrinho', $livro->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="livros_id" value="{{ $livro->id }}">
                                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center space-x-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                                                    </svg>
                                                    <span>Adicionar ao Carrinho</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="bg-green-100 text-green-800 font-semibold py-2 px-6 rounded-lg flex items-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>No Carrinho</span>
                                            </div>
                                        @endif
                                    @else
                                        @if (!$jaSolicitado)
                                            @if (!$notificado)
                                                <form method="POST" action="{{ route('livro.notificar', $livro->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center space-x-2">
                                                        <i class="fas fa-bell w-5 h-5"></i>
                                                        <span>Notificar Disponibilidade</span>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="bg-gray-100 text-gray-600 font-semibold py-2 px-6 rounded-lg flex items-center space-x-2">
                                                    <i class="fas fa-check-circle w-5 h-5"></i>
                                                    <span>Notificação Ativa</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="bg-yellow-100 text-yellow-800 font-semibold py-2 px-6 rounded-lg flex items-center space-x-2">
                                                <i class="fas fa-info-circle w-5 h-5"></i>
                                                <span>Você já tem uma requisição ativa para este livro</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Reviews dos Leitores</h3>
                <span class="text-sm text-gray-500">{{ $livro->reviews->count() }} review(s)</span>
            </div>

            @if($livro->reviews->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.001 8.001 0 01-7.75-6M3 12c0-4.418 3.582-8 8-8s8 3.582 8 8"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum review ainda</h3>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($livro->reviews as $review)
                        <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded-r-lg">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                        <span class="text-sm text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="mt-2 text-gray-700 leading-relaxed">{{ $review->descricao }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        
        @if($relacionados->isNotEmpty())
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    Livros Relacionados
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relacionados as $livroRel)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                            <h4 class="font-bold text-gray-900 mb-2">{{ $livroRel->nome }}</h4>
                            <p class="text-sm text-gray-600 mb-3 leading-relaxed">{{ Str::limit($livroRel->bibliografia, 100) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold text-gray-900">€{{ number_format($livroRel->preco, 2) }}</span>
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