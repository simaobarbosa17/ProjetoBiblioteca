<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                ✅  {{ __('Admin Requisições') }}
            </h2>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total de Requisições</div>
                    <div class="stat-value text-primary">{{ $requisicao->total() }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="rounded shadow p-4 border-l-4 border-green-500">
                <h3 class="text-lg font-bold text-green-600">Requisições Ativas</h3>
                <p class="text-3xl mt-2">{{ $totalAtivas }}</p>
            </div>
            <div class="rounded shadow p-4 border-l-4 border-red-500">
                <h3 class="text-lg font-bold text-red-600">Requisições Devolvidas</h3>
                <p class="text-3xl mt-2">{{ $totalDevolvidas }}</p>
            </div>
            <div class="rounded shadow p-4 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-blue-600">Últimos 30 Dias</h3>
                <p class="text-3xl mt-2">{{ $ultimos30dias }}</p>
            </div>
            <div class=" rounded shadow p-4 border-l-4 border-yellow-500">
                <h3 class="text-lg font-bold text-yellow-600">Entregues Hoje</h3>
                <p class="text-3xl mt-2">{{ $entreguesHoje }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold text-green-700 mb-4">Requisições Ativas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($requisicoesAtivas as $requisicao)
                    <div class="card bg-base-100 shadow border-l-4 border-green-500">
                        <div class="card-body">
                            <p><strong>Utilizador:</strong> {{ $requisicao->user->name }}</p>
                            <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                            <p><strong>Requisitado em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</p>
                            <p><strong>Entrega prevista:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                            <p><strong>Estado:</strong> {{ ucfirst($requisicao->estado) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-2">Nenhuma requisição ativa encontrada.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $requisicoesAtivas->links() }}
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold text-red-700 mb-4">Requisições Devolvidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($requisicoesDevolvidas as $requisicao)
                    <div class="card bg-base-100 shadow border-l-4 border-red-500">
                        <div class="card-body">
                            <p><strong>Utilizador:</strong> {{ $requisicao->user->name }}</p>
                            <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                            <p><strong>Requisitado em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</p>
                            <p><strong>Entrega prevista:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>
                            <p><strong>Entregue em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_devolvida)->format('d/m/Y') }}</p>
                            <p><strong>Estado:</strong> {{ ucfirst($requisicao->estado) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-2">Nenhuma requisição devolvida encontrada.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $requisicoesDevolvidas->links() }}
            </div>
        </div>

    </div>
</x-app-layout>