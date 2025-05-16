<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Autores') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <form action="{{ route('autores') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
                        <input type="text" name="procurar" value="{{ request('procurar') }}"
                            placeholder="Procurar por nome ou id" class="input input-bordered w-full" />
                        <button type="submit" class="btn btn-primary">Procurar</button>
                    </form>
                </div>
                <div class="mb-4 text-right">
                    <a href="{{ route('admin.autores.create') }}" class="btn btn-success">
                        ➕ Inserir Autor
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
                            $url = route('admin.autores', $params);
                            return '<a href="' . $url . '" class="hover:underline">' . $label . '</a>';
                        }
                    @endphp
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200 text-base-content">
                                <th class="py-2 px-3 text-center">{!! sortLink('ID', 'id') !!}</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Nome', 'nome') !!}</th>
                                <th class="py-2 px-3 text-center">Foto</th>
                                <th class="py-2 px-3 text-center"></th>
                                <th class="py-2 px-3 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($autor as $autores)
                                <tr class="hover:bg-base-200/50 border-b border-base-200">
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $autores->id }}</td>
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $autores->nome }}</td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col items-center gap-2">
                                            <img src="{{ Storage::url(str_replace('storage/app/public/', '', $autores->foto)) }}"
                                                alt="Foto do Autor" width="130" height="170"
                                                class="object-contain shadow-sm border border-gray-200">
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ route('admin.autores.edit', $autores->id) }}"
                                            class="btn btn-sm btn-warning">
                                            ✏️ Editar
                                        </a>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <form action="{{ route('admin.autores.destroy', $autores->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja remover esta Editora?')">
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
                {{ $autor->links() }}
            </div>
        </div>
    </div>
</x-app-layout>