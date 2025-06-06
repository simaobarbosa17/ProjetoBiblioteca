<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Encomendas</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
       
        <div>
            <h3 class="text-xl font-bold text-green-700 mb-4">Encomendas Pagas</h3>
            @forelse($encomendas->where('paga', true) as $encomenda)
                <div class="bg-white p-6 rounded shadow mb-4 border border-green-200">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <strong>User:</strong> {{ $encomenda->user->name }}<br>
                            <strong>Morada:</strong> {{ $encomenda->morada }}<br>
                            <strong>Data:</strong> {{ $encomenda->created_at->format('d/m/Y H:i') }}
                        </div>
                        <span class="text-green-600 font-semibold">✅ Paga</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        @foreach($encomenda->livros as $livro)
                            <li>{{ $livro->nome }} — €{{ number_format($livro->preco, 2, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-gray-500">Nenhuma encomenda paga encontrada.</p>
            @endforelse
        </div>

       
        <div>
            <h3 class="text-xl font-bold text-red-700 mb-4">Encomendas Pendentes</h3>
            @forelse($encomendas->where('paga', false) as $encomenda)
                <div class="bg-white p-6 rounded shadow mb-4 border border-red-200">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <strong>User:</strong> {{ $encomenda->user->name }}<br>
                            <strong>Morada:</strong> {{ $encomenda->morada }}<br>
                            <strong>Data:</strong> {{ $encomenda->created_at->format('d/m/Y H:i') }}
                        </div>
                        <span class="text-red-600 font-semibold">❌ Pendente</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        @foreach($encomenda->livros as $livro)
                            <li>{{ $livro->nome }} — €{{ number_format($livro->preco, 2, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-gray-500">Nenhuma encomenda pendente encontrada.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>