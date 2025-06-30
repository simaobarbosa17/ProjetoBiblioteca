<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                📚 {{ __('Administração de Livros') }}
            </h2>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total de Livros</div>
                    <div class="stat-value text-primary">{{ $livro->total() }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto p-6 space-y-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">🔍 Filtros de Pesquisa</h3>
                <form action="{{ route('admin.dashboard') }}" method="GET" class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Pesquisar livros</span>
                        </label>
                        <div class="join w-full">
                            <input type="text" 
                                   name="procurar" 
                                   value="{{ request('procurar') }}"
                                   placeholder="Digite o nome, ISBN, editora ou autor..."
                                   class="input input-bordered join-item flex-1" />
                            <button type="submit" class="btn btn-primary join-item">
                                🔍 Pesquisar
                            </button>
                        </div>
                    </div>
                    @if(request('procurar'))
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Pesquisando por: <strong>"{{ request('procurar') }}"</strong></span>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-ghost">✖️ Limpar</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <div>
                <a href="{{ route('admin.livros.create') }}" class="btn btn-success gap-2 hover:scale-105 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Novo Livro
                </a>
            </div>
            <div>
                <a href="{{ route('admin.importarlivro.form') }}" class="btn btn-info gap-2 hover:scale-105 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Importar Livros
                </a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto max-w-full">
                    <div class="min-w-max">
                    @php
                        $Sortatual = request('sort', 'isbn');
                        $Ordematual = request('ordenar', 'asc');
                        function sortLink($label, $campo)
                        {
                            $novaordem = request('sort') === $campo && request('ordenar') === 'asc' ? 'desc' : 'asc';
                            $params = array_merge(request()->all(), ['sort' => $campo, 'ordenar' => $novaordem]);
                            $url = route('admin.dashboard', $params);
                            $icon = request('sort') === $campo ? (request('ordenar') === 'asc' ? '↑' : '↓') : '';
                            return '<a href="' . $url . '" class="hover:text-primary transition-colors font-semibold">' . $label . ' ' . $icon . '</a>';
                        }
                    @endphp
                    
                    <table class="table table-zebra w-full min-w-max">
                        <thead>
                            <tr class="bg-base-200">
                                <th class="text-center font-bold min-w-[120px]">{!! sortLink('ISBN', 'isbn') !!}</th>
                                <th class="text-center font-bold min-w-[200px]">{!! sortLink('Título', 'nome') !!}</th>
                                <th class="text-center font-bold min-w-[120px]">{!! sortLink('Editora', 'editora') !!}</th>
                                <th class="text-center font-bold min-w-[150px]">{!! sortLink('Autores', 'autor') !!}</th>
                                <th class="text-center font-bold min-w-[200px]">Bibliografia</th>
                                <th class="text-center font-bold min-w-[100px]">Capa</th>
                                <th class="text-center font-bold min-w-[100px]">{!! sortLink('Preço (€)', 'preco') !!}</th>
                                <th class="text-center font-bold min-w-[80px]">Stock</th>
                                <th class="text-center font-bold min-w-[150px]">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($livro as $livros)
                                <tr class="hover">
                                    <td class="text-center min-w-[120px]">
                                        <div class="font-mono text-xs bg-base-200 px-2 py-1 rounded">
                                            {{ $livros->isbn }}
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[200px]">
                                        <div class="font-semibold text-sm">
                                            {{ Str::limit($livros->nome, 30, '...') }}
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[120px]">
                                        <span class="text-sm font-medium">
                                            {{ $livros->editora->nome }}
                                        </span>
                                    </td>
                                    <td class="text-center min-w-[150px]">
                                        <div class="space-y-1">
                                            @foreach ($livros->autores as $autor)
                                                <div class="badge badge-ghost badge-sm">{{ $autor->nome }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[200px]">
                                        <div class="text-sm opacity-70">
                                            {{ Str::limit($livros->bibliografia, 50, '...') }}
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[100px]">
                                        <div class="avatar">
                                            <div class="w-16 h-20 rounded">
                                                <img src="{{ asset($livros->capa) }}" 
                                                     alt="Capa: {{ $livros->nome }}"
                                                     class="object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[100px]">
                                        <div class="stat-value text-lg text-success">
                                            €{{ number_format($livros->preco, 2) }}
                                        </div>
                                    </td>
                                    <td class="text-center min-w-[80px]">
                                        @if($livros->stock > 10)
                                            <div class="badge badge-success">{{ $livros->stock }}</div>
                                        @elseif($livros->stock > 0)
                                            <div class="badge badge-warning">{{ $livros->stock }}</div>
                                        @else
                                            <div class="badge badge-error">{{ $livros->stock }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center min-w-[150px]">
                                        <div class="join join-vertical sm:join-horizontal">
                                            <a href="{{ route('admin.detalhelivroadmin.show', $livros->id) }}"
                                               class="btn btn-xs btn-primary join-item hover:scale-105 transition-transform duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.livros.edit', $livros->id) }}"
                                               class="btn btn-xs btn-warning join-item hover:scale-105 transition-transform duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-10 4l8-8m-3-3l3 3" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.livros.destroy', $livros->id) }}" method="POST" onsubmit="return confirm('Deseja mesmo apagar este livro?');" class="join-item">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-error hover:scale-105 transition-transform duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="card-actions justify-center p-4">
                    {{ $livro->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover\:scale-105:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</x-app-layout>
