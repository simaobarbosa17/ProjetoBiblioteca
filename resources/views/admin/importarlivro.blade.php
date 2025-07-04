<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Admin Importar Livros') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <form action="{{ route('admin.importarlivro.form') }}" method="GET" class="mb-6">
                        <div class="flex items-center border-2 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border-base-300">
                            <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Procurar por título" 
                                   class="w-full py-3 px-4 outline-none input input-bordered input-primary" />
                            <button type="submit" class="btn btn-primary flex items-center px-6 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Procurar
                            </button>
                        </div>
                    </form>

                    @if(count($livros) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($livros as $livro)
                                <div class="card shadow hover:shadow-lg flex flex-col h-full">
                                    <figure class="h-64 bg-base-200 flex items-center justify-center p-4">
                                        @if(isset($livro['volumeInfo']['imageLinks']['thumbnail']))
                                            <img src="{{ $livro['volumeInfo']['imageLinks']['thumbnail'] }}" alt="Capa" 
                                                 class="h-full object-contain" />
                                        @else
                                            <div class="w-32 h-48 bg-base-300 flex items-center justify-center text-base-content/50">
                                                <span>Sem imagem</span>
                                            </div>
                                        @endif
                                    </figure>
                                
                                    <div class="card-body flex-grow flex flex-col p-4">
                                        <h3 class="card-title line-clamp-2 h-14">
                                            {{ $livro['volumeInfo']['title'] ?? 'Sem título' }}
                                        </h3>
                                        <p class="italic mb-2 h-6 overflow-hidden text-base-content/70">
                                            {{ implode(', ', $livro['volumeInfo']['authors'] ?? ['Autor desconhecido']) }}
                                        </p>
                                        @if(isset($livro['volumeInfo']['industryIdentifiers']))
                                            <p class="text-sm mb-3 h-5 text-base-content/60">
                                                ISBN: {{ $livro['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? 'N/A' }}
                                            </p>
                                        @else
                                            <p class="text-sm mb-3 h-5 text-base-content/60">
                                                ISBN: N/A
                                            </p>
                                        @endif
                                        
                                        <div class="mb-4 flex-grow">
                                            @if(isset($livro['volumeInfo']['description']))
                                                <p class="text-sm line-clamp-3 text-base-content">
                                                    {{ \Illuminate\Support\Str::limit($livro['volumeInfo']['description'], 150) }}
                                                </p>
                                            @else
                                                <p class="text-sm italic text-base-content/50">
                                                    Sem descrição disponível
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-actions p-4 border-t border-base-300 mt-auto">
                                        <form action="{{ route('admin.importarlivro.salvar') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="isbn" value="{{ $livro['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? 'SEMISBN' }}">
                                            <input type="hidden" name="nome" value="{{ $livro['volumeInfo']['title'] ?? '' }}">
                                            <input type="hidden" name="autores" value="{{ implode(', ', $livro['volumeInfo']['authors'] ?? []) }}">
                                            <input type="hidden" name="bibliografia" value="{{ $livro['volumeInfo']['description'] ?? '' }}">
                                            <input type="hidden" name="capa" value="{{ $livro['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}">
                                            <button type="submit" class="btn btn-primary w-full flex items-center justify-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Importar Livro
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-xl font-medium">Nenhum livro encontrado</p>
                            <p class="mt-2">Tente realizar uma nova busca com termos diferentes</p>
                        </div>
                    @endif
                </div>

                @if ($totalPages > 1)
                    <div class="mt-8 flex justify-center space-x-2">
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <a href="{{ route('admin.importarlivro.form', ['q' => $query, 'page' => $i]) }}"
                                class="btn btn-outline {{ $i == $page ? 'btn-primary' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>