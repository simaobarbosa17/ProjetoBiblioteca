<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editoras') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <form action="{{ route('editoras') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
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
                            $url = route('editoras', $params);
                            return '<a href="' . $url . '" class="hover:underline">' . $label . '</a>';
                        }
                    @endphp
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200 text-base-content">
                                <th class="py-2 px-3 text-center">{!! sortLink('ID', 'id') !!}</th>
                                <th class="py-2 px-3 text-center">{!! sortLink('Nome', 'nome') !!}</th>
                                <th class="py-2 px-3 text-center">Logotipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($editora as $editoras)
                                <tr class="hover:bg-base-200/50 border-b border-base-200">
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $editoras->id }}</td>
                                    <td class="py-3 px-3 font-mono text-sm text-center">{{ $editoras->nome }}</td>
                                    <td class="py-3 px-3 flex justify-center items-center">
                                        <img src="{{ Storage::url(str_replace('storage/app/public/', '', $editoras->logótipo)) }}"
                                            alt="Logotipo da editora" width="80" height="80"
                                            class="object-contain shadow-sm border border-gray-200">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $editora->links() }}
            </div>
        </div>
    </div>
</x-app-layout>