<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Todas as Requisições
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded shadow p-4 border-l-4 border-green-500">
                <h3 class="text-lg font-bold text-green-600">Requisições Ativas</h3>
                <p class="text-3xl mt-2">{{ $totalAtivas }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 border-l-4 border-red-500">
                <h3 class="text-lg font-bold text-red-600">Requisições Devolvidas</h3>
                <p class="text-3xl mt-2">{{ $totalDevolvidas }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-blue-600">Últimos 30 Dias</h3>
                <p class="text-3xl mt-2">{{ $ultimos30dias }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 border-l-4 border-yellow-500">
                <h3 class="text-lg font-bold text-yellow-600">Entregues Hoje</h3>
                <p class="text-3xl mt-2">{{ $entreguesHoje }}</p>
            </div>
        </div>

        
        <div>
            <h3 class="text-xl font-semibold text-green-700 mb-4">Requisições Ativas</h3>
            @forelse($requisicoesAtivas as $requisicao)
                <div class="bg-white p-4 rounded shadow mb-4 border-l-4 border-green-500">
                    <p><strong>Usuário:</strong> {{ $requisicao->user->name }}</p>
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p><strong>Requisitado em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</p>
                    <p><strong>Entrega prevista:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                    <p><strong>Entregue em:</strong> 
                        {{ $requisicao->data_devolvida ? \Carbon\Carbon::parse($requisicao->data_devolvida)->format('d/m/Y') : 'Data não registrada' }}
                    </p>
                    <p><strong>Estado:</strong> {{ ucfirst($requisicao->estado) }}</p>
                    </div>
            @empty
                <p class="text-gray-600">Nenhuma requisição ativa encontrada.</p>
            @endforelse

            {{ $requisicoesAtivas->links() }}
        </div>

        
        <div>
            <h3 class="text-xl font-semibold text-red-700 mb-4">Requisições Devolvidas</h3>
            @forelse($requisicoesDevolvidas as $requisicao)
                <div class="bg-white p-4 rounded shadow mb-4 border-l-4 border-red-500">
                    <p><strong>Usuário:</strong> {{ $requisicao->user->name }}</p>
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p><strong>Requisitado em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</p>
                    <p><strong>Entrega prevista:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($requisicao->estado) }}</p>
                </div>
            @empty
                <p class="text-gray-600">Nenhuma requisição devolvida encontrada.</p>
            @endforelse

            {{ $requisicoesDevolvidas->links() }}
        </div>

    </div>
</x-app-layout>