<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                🏢 {{ __('Administração de Editoras') }}
            </h2>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total de Editoras</div>
                    <div class="stat-value text-primary">{{ $editora->total() }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto p-6 space-y-6">

        
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">🔍 Filtros de Pesquisa</h3>

                <form action="{{ route('editoras') }}" method="GET" class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Pesquisar editoras</span>
                        </label>

                        <div class="join w-full">
                            <input
                                type="text"
                                name="procurar"
                                value="{{ request('procurar') }}"
                                placeholder="Digite o nome ou ID da editora…"
                                class="input input-bordered join-item flex-1" />

                            <button type="submit" class="btn btn-primary join-item">
                                🔍 Pesquisar
                            </button>
                        </div>
                    </div>

                    @if(request('procurar'))
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current w-6 h-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                            </svg>
                            <span>Pesquisando por: <strong>“{{ request('procurar') }}”</strong></span>
                            <a href="{{ route('editoras') }}" class="btn btn-sm btn-ghost">✖️ Limpar</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

       
        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <div class="tooltip tooltip-bottom" data-tip="Adicionar uma nova editora">
                <a href="{{ route('admin.editoras.create') }}"
                   class="btn btn-success gap-2 hover:scale-105 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nova Editora
                </a>
            </div>
        </div>

      
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
              
                <div class="overflow-x-auto overflow-y-auto max-w-full" style="max-height: 800px;">
                    <div class="min-w-max">
                        @php
                            $Sortatual = request('sort', 'id');
                            $Ordematual = request('ordenar', 'asc');
                            function sortLink($label,$campo){
                                $novaordem = request('sort') === $campo && request('ordenar') === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->all(),['sort'=>$campo,'ordenar'=>$novaordem]);
                                $url = route('admin.editoras',$params);
                                $icon = request('sort')===$campo ? (request('ordenar')==='asc'?'↑':'↓') : '';
                                return '<a href="'.$url.'" class="hover:text-primary transition-colors font-semibold">'.$label.' '.$icon.'</a>';
                            }
                        @endphp

                        <table class="table table-zebra w-full min-w-max">
                            <thead>
                                <tr class="bg-base-200">
                                    <th class="text-center font-bold min-w-[90px]">{!! sortLink('ID','id') !!}</th>
                                    <th class="text-center font-bold min-w-[250px]">{!! sortLink('Nome','nome') !!}</th>
                                    <th class="text-center font-bold min-w-[180px]">Logotipo</th>
                                    <th class="text-center font-bold min-w-[150px]">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($editora as $editoras)
                                    <tr class="hover">
                                        <td class="text-center font-mono text-sm">{{ $editoras->id }}</td>

                                        <td class="text-center font-semibold">{{ $editoras->nome }}</td>

                                        <td class="text-center">
                                            @if($editoras->logótipo)
                                                <img src="{{ Storage::url(str_replace('storage/app/public/','',$editoras->logótipo)) }}"
                                                     alt="Logo {{ $editoras->nome }}"
                                                     class="mx-auto w-24 h-24 object-contain border border-base-300 shadow-sm">
                                            @else
                                                <span class="text-sm opacity-60">Sem imagem</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="join join-vertical sm:join-horizontal justify-center">
                                                <a href="{{ route('admin.editoras.edit',$editoras->id) }}"
                                                   class="btn btn-xs btn-warning join-item hover:scale-105 transition-transform duration-200"
                                                   title="Editar editora">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('admin.editoras.destroy',$editoras->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('⚠️ Tem certeza que deseja remover esta editora? Esta ação não pode ser desfeita!')"
                                                      class="inline join-item">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-xs btn-error hover:scale-105 transition-transform duration-200"
                                                            title="Remover editora">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

             
                @if($editora->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🏢</div>
                        <h3 class="text-xl font-semibold mb-2">Nenhuma editora encontrada</h3>
                        <p class="text-base-content/60 mb-4">
                            @if(request('procurar'))
                                Não foram encontradas editoras com os critérios de pesquisa utilizados.
                            @else
                                Ainda não há editoras cadastradas no sistema.
                            @endif
                        </p>
                        <div class="space-x-2">
                            @if(request('procurar'))
                                <a href="{{ route('editoras') }}" class="btn btn-ghost">Limpar Filtros</a>
                            @endif
                            <a href="{{ route('admin.editoras.create') }}" class="btn btn-primary">Adicionar Primeira Editora</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    
        @if($editora->hasPages())
            <div class="flex justify-center mt-6">
                {{ $editora->links() }}
            </div>
        @endif
    </div>

    <style>
        .hover\:scale-105:hover {
            transform:scale(1.05);
            transition:transform .2s ease-in-out;
        }
    </style>
</x-app-layout>