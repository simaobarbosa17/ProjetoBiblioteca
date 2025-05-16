<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Livros') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
                        <input type="text" name="procurar" value="{{ request('procurar') }}"
                            placeholder="Procurar por nome, ISBN, editora ou autor"
                            class="input input-bordered w-full" />
                        <button type="submit" class="btn btn-primary">Procurar</button>
                    </form>
                </div>
                <div class="mb-4 text-right">
                    <a href="{{ route('admin.livros.create') }}" class="btn btn-success">
                        ➕ Inserir Livro
                    </a>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $Sortatual = request('sort', 'isbn');
                        $Ordematual = request('ordenar', 'asc');
                        function sortLink($label, $campo)
                        {
                            $novaordem = request('sort') === $campo && request('ordenar') === 'asc' ? 'desc' : 'asc';
                            $params = array_merge(request()->all(), ['sort' => $campo, 'ordenar' => $novaordem]);
                            $url = route('admin.dashboard', $params);
                            return '<a href="' . $url . '" class="hover:underline">' . $label . '</a>';
                        }
                    @endphp
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200 text-base-content">
                                <th class=" py-2 px-3 text-center">{!! sortLink('ISBN', 'isbn') !!}</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Nome', 'nome') !!}</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Editora', 'editora') !!}</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Autores', 'autor') !!}</th>
                                <th class="py-2 px-3 text-center">Bibliografia</th>
                                <th class="py-2 px-3 text-center">Capa</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Preço(€)', 'preco') !!}</th>
                                <th class="py-2 px-3 text-center"></th>
                                <th class="py-2 px-3 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($livro as $livros)
                                <tr class="hover:bg-base-200/50 border-b border-base-200">
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $livros->isbn }}</td>
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $livros->nome }}</td>
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $livros->editora->nome }}
                                    </td>
                                    <td class="py-3 px-3 font-mono text-sm text-center">
                                        @foreach ($livros->autores as $autor)
                                        <span class="block">{{ $autor->nome }},</span> @endforeach
                                    </td>
                                    <td class="py-3 px-3 max-w-xs">
                                        <div class="tooltip tooltip-left" data-tip="{{ $livros->bibliografia }}">
                                            <div class="text-sm whitespace-pre-line">
                                                {!! nl2br(e($livros->bibliografia)) !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 flex justify-center items-center">
                                        <img src="{{ asset($livros->capa) }}" 
                                            alt="Capa do livro" width="160" height="200"
                                            class="object-contain shadow-sm border border-gray-200">
                                    </td>
                                    <td class="py-3 px-3 text-center font-medium">
                                        {{$livros->preco}}
                                    </td>
                                    <td class=" py-3 px-3 flex flex-col sm:flex-row justify-center items-center gap-2">
                                        <a href="{{ route('admin.livros.edit', $livros->id) }}"
                                            class="btn btn-sm btn-warning">
                                            ✏️ Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.livros.destroy', $livros->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja remover este livro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">
                                                🗑️ Remover
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $livro->links() }}
            </div>
        </div>
    </div>
</x-app-layout>