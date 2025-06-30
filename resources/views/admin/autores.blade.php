<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                👨‍💼 {{ __('Administração de Autores') }}
            </h2>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total de Autores</div>
                    <div class="stat-value text-primary">{{ $autor->total() }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto p-6 space-y-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">🔍 Filtros de Pesquisa</h3>
                <form action="{{ route('autores') }}" method="GET" class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Pesquisar autores</span>
                        </label>
                        <div class="join w-full">
                            <input type="text"
                                   name="procurar"
                                   value="{{ request('procurar') }}"
                                   placeholder="Digite o nome ou ID do autor..."
                                   class="input input-bordered join-item flex-1" />
                            <button type="submit" class="btn btn-primary join-item">
                                🔍 Pesquisar
                            </button>
                        </div>
                    </div>
                    @if(request('procurar'))
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                 class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Pesquisando por: <strong>"{{ request('procurar') }}"</strong></span>
                            <a href="{{ route('autores') }}" class="btn btn-sm btn-ghost">✖️ Limpar</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <div class="tooltip tooltip-bottom" data-tip="Adicionar um novo autor">
                <a href="{{ route('admin.autores.create') }}" class="btn btn-success gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Novo Autor
                </a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto max-w-full">
                    <div class="min-w-max">
                        @php
                            $Sortatual = request('sort', 'id');
                            $Ordematual = request('ordenar', 'asc');
                            function sortLink($label, $campo)
                            {
                                $novaordem = request('sort') === $campo && request('ordenar') === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->all(), ['sort' => $campo, 'ordenar' => $novaordem]);
                                $url = route('autores', $params);
                                $icon = request('sort') === $campo ? (request('ordenar') === 'asc' ? '↑' : '↓') : '';
                                return '<a href="' . $url . '" class="hover:text-primary transition-colors font-semibold">' . $label . ' ' . $icon . '</a>';
                            }
                        @endphp
                        <table class="table table-zebra w-full text-base">
                            <thead>
                                <tr class="bg-base-200">
                                    <th class="text-center font-bold min-w-[100px]">{!! sortLink('ID', 'id') !!}</th>
                                    <th class="text-center font-bold min-w-[250px]">{!! sortLink('Nome', 'nome') !!}</th>
                                    <th class="text-center font-bold min-w-[150px]">Foto</th>
                                    <th class="text-center font-bold min-w-[150px]">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($autor as $autores)
                                    <tr class="hover">
                                        <td class="text-center min-w-[100px] font-mono text-sm">
                                            {{ $autores->id }}
                                        </td>
                                        <td class="text-center min-w-[250px] font-semibold text-sm text-base-content">
                                            {{ $autores->nome }}
                                        </td>
                                        <td class="text-center min-w-[150px]">
                                            <div class="avatar mx-auto">
                                                <div class="w-20 h-24 rounded shadow-sm border border-base-300 overflow-hidden">
                                                    <img src="{{ Storage::url(str_replace('storage/app/public/', '', $autores->foto)) }}" 
                                                         alt="Foto do Autor {{ $autores->nome }}" 
                                                         class="object-contain w-full h-full" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center min-w-[150px]">
                                            <div class="join join-vertical sm:join-horizontal justify-center">
                                                <a href="{{ route('admin.autores.edit', $autores->id) }}" 
                                                   class="btn btn-xs btn-warning join-item" 
                                                   title="Editar autor">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.autores.destroy', $autores->id) }}" method="POST" 
                                                      onsubmit="return confirm('⚠️ Tem certeza que deseja remover este autor? Esta ação não pode ser desfeita!')"
                                                      class="inline join-item">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-error" title="Remover autor">
                                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

                @if($autor->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">👨‍💼</div>
                        <h3 class="text-xl font-semibold mb-2">Nenhum autor encontrado</h3>
                        <p class="text-base-content/60 mb-4">
                            @if(request('procurar'))
                                Não foram encontrados autores com os critérios de pesquisa utilizados.
                            @else
                                Ainda não há autores cadastrados no sistema.
                            @endif
                        </p>
                        <div class="space-x-2">
                            @if(request('procurar'))
                                <a href="{{ route('autores') }}" class="btn btn-ghost">Limpar Filtros</a>
                            @endif
                            <a href="{{ route('admin.autores.create') }}" class="btn btn-primary">Adicionar Primeiro Autor</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @if($autor->hasPages())
            <div class="flex justify-center mt-6">
                <div class="join">
                    {{ $autor->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover\:scale-105:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease-in-out;
        }
        .tooltip:before {
            white-space: normal;
            max-width: 200px;
            text-align: center;
        }
    </style>
</x-app-layout>