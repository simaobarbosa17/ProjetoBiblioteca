<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autores') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <form action="{{ route('autores') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
                        <input type="text" name="procurar" value="{{ request('procurar') }}"
                            placeholder="Procurar por ID ou nome" class="input input-bordered w-full" />
                        <button type="submit" class="btn btn-primary">Procurar</button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $Sortatual = request('sort', 'id');
                        $Ordematual = request('ordenar', 'asc');
                        function sortLink($label, $campo)
                        {
                            $novaordem = request('sort') === $campo && request('ordenar') === 'asc' ? 'desc' : 'asc';
                            $params = array_merge(request()->all(), ['sort' => $campo, 'ordenar' => $novaordem]);
                            $url = route('autores', $params);
                            return '<a href="' . $url . '" class="hover:underline">' . $label . '</a>';
                        }
                    @endphp
                    <div class="flex justify-center">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="bg-base-200 text-base-content">
                                    <th class="py-2 px-3 text-center w-1/6">{!! sortLink('ID', 'id') !!}</th>
                                    <th class="py-2 px-3 text-center w-2/6">{!! sortLink('Nome', 'nome') !!}</th>
                                    <th class="py-2 px-3 text-center w-3/6">Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($autor as $autores)
                                    <tr class="hover:bg-base-200/50 border-b border-base-200">
                                        <td class="py-3 px-3 font-mono text-sm text-center align-middle">{{ $autores->id }}
                                        </td>
                                        <td class="py-3 px-3 font-mono text-sm text-center align-middle">
                                            {{ $autores->nome }}
                                        </td>
                                        <td class="py-3 px-3 text-center align-middle">
                                            <div class="flex justify-center items-center h-full">
                                                <img src="{{ Storage::url(str_replace('storage/app/public/', '', $autores->foto)) }}"
                                                    alt="Logotipo da editora" width="80" height="80"
                                                    class="object-contain shadow-sm border border-gray-200">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                {{ $autor->links() }}
            </div>
        </div>
    </div>
</x-app-layout>