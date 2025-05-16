<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Minhas Requisições
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-8">

        
        <div>
            <h3 class="text-lg font-bold text-green-600 mb-4">Requisições Ativas</h3>
            @forelse($ativas as $requisicao)
                <div class="bg-white p-4 rounded shadow mb-2 border-l-4 border-green-500">
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p><strong>Entrega até:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-600">Nenhuma requisição ativa.</p>
            @endforelse
        </div>


        <div>
            <h3 class="text-lg font-bold text-red-600 mb-4">Requisições Finalizadas</h3>
            @forelse($naoAtivas as $requisicao)
                <div class="bg-white p-4 rounded shadow mb-2 border-l-4 border-red-500">
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p><strong>Entregue em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-600">Nenhuma requisição finalizada.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>