<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-base-content flex items-center gap-2">
             <span>Lista de Livros</span>
            <div class="badge badge-primary badge-sm">Biblioteca Digital</div>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Barra de pesquisa -->
            <div class="card bg-base-100 shadow-xl mb-8">
                <div class="card-body">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="procurar" value="{{ request('procurar') }}"
                                placeholder="Procurar por nome, ISBN, editora ou autor"
                                class="input input-bordered w-full" />
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/50">
                                🔍
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Procurar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="stats shadow mb-8 w-full flex flex-col sm:flex-row sm:space-x-6">
                <div class="stat w-full sm:w-1/3 mb-4 sm:mb-0">
                    <div class="stat-figure text-primary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Total de Livros</div>
                    <div class="stat-value text-primary">{{ $livro->total() }}</div>
                    <div class="stat-desc">Na biblioteca digital</div>
                </div>
                
                <div class="stat w-full sm:w-1/3 mb-4 sm:mb-0">
                    <div class="stat-figure text-secondary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Página Atual</div>
                    <div class="stat-value text-secondary">{{ $livro->currentPage() }}</div>
                    <div class="stat-desc">de {{ $livro->lastPage() }} páginas</div>
                </div>
                
                <div class="stat w-full sm:w-1/3">
                    <div class="stat-figure text-accent">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Resultados</div>
                    <div class="stat-value text-accent">{{ $livro->count() }}</div>
                    <div class="stat-desc">Nesta página</div>
                </div>
            </div>

            <!-- Grelha de livros -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($livro as $livros)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                        <figure class="px-4 pt-4">
                            <img src="{{ asset($livros->capa) }}" alt="Capa do livro"
                                class="rounded-xl h-60 w-full object-contain" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title text-lg">
                                {{ $livros->nome }}
                            </h2>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-outline badge-xs">ISBN</span>
                                    <span class="opacity-70">{{ $livros->isbn }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-outline badge-xs">Editora</span>
                                    <span class="opacity-70">{{ $livros->editora->nome }}</span>
                                </div>
                                
                                <div class="flex items-start gap-2">
                                    <span class="badge badge-outline badge-xs mt-0.5">Autores</span>
                                    <span class="opacity-70 flex-1">
                                        @foreach ($livros->autores as $autor)
                                            {{ $autor->nome }}@if (!$loop->last), @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            
                            <p class="text-sm mt-3 opacity-80">
                                {{ Str::limit($livros->bibliografia, 120, '...') }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="text-2xl font-bold text-primary">€{{ $livros->preco }}</div>
                                <div class="badge badge-secondary">Disponível</div>
                            </div>

                            <div class="card-actions justify-between mt-6">
                                <a href="{{ route('requisicoes.show', $livros->id) }}" 
                                   class="btn btn-primary btn-sm flex-1">
                                    📚 Requisitar
                                </a>
                                <a href="{{ route('detalhelivro.show', $livros->id) }}" 
                                   class="btn btn-outline btn-sm">
                                    ℹ️ Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-12 flex justify-center">
                <div class="join">
                    {{ $livro->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
