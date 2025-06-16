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
                <div class="bg-white p-4 rounded shadow mb-4 border-l-4 border-green-500">
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p><strong>Entrega até:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>

                   <form action="{{ route('requisicoes.devolver', $requisicao->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-black font-bold py-1 px-3 rounded">
                             Devolver
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-600">Nenhuma requisição ativa.</p>
            @endforelse
        </div>


            <div>
    <h3 class="text-lg font-bold text-red-600 mb-4">Requisições Devolvidas</h3>

   @forelse($naoAtivas as $requisicao)
    <div class="bg-white p-4 rounded shadow mb-4 border-l-4 border-red-500">
        <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
        <p><strong>Entregue em:</strong> {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</p>

    @if ($requisicao->review === null)
            <form action="{{ route('reviews.store') }}" method="POST" class="mt-4 space-y-2">
    @csrf
    <input type="hidden" name="requesicoes_id" value="{{ $requisicao->id }}">
    <input type="hidden" name="livros_id" value="{{ $requisicao->livro->id }}">

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700">Comentário:</label>
        <textarea name="descricao" rows="3" required class="textarea textarea-bordered w-full"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar Review</button>
</form>
        @else
            <p class="mt-2 text-green-600">✅ Review já enviada.</p>
        @endif
    </div>
@empty
    <p class="text-gray-600">Nenhuma requisição finalizada.</p>
@endforelse
</div>

    </div>
</x-app-layout>