<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhe Livro: {{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-6">
        <div class="bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold mb-4">Informações do Livro</h3>
            <p><strong>ISBN:</strong> {{ $livro->isbn }}</p>
            <p><strong>Editora:</strong> {{ $livro->editora->nome }}</p>
            <p><strong>Autores</strong> 
                @foreach ($livro->autores as $autor)
                 {{ $autor->nome }},
                 @endforeach</p>
            <p><strong>Bibliografia:</strong> {{ $livro->bibliografia }}</p>
            <p><strong>Preço:</strong> €{{ $livro->preco }}</p>
            <div class="mt-3">
              <img src="{{ asset($livro->capa) }}" 
                    alt="Capa do livro" width="200" height="240"
                    class="object-contain shadow-sm border border-gray-200">
            </div>
        </div>
        @if (!$livro->disponivel && !$notificado)
            <form method="POST" action="{{ route('livro.notificar', $livro->id) }}">
                @csrf
                <button class="btn btn-warning mt-2">🔔 Notificar quando disponível</button>
            </form>
        @endif
        <div class="bg-white p-6 shadow rounded mt-6">
       
    <h3 class="text-lg font-semibold mb-4">Reviews</h3>

    @if($livro->reviews->isEmpty())
        <p class="text-gray-600">Ainda não há reviews para este livro.</p>
    @else
        @foreach($livro->reviews as $review)
            <div class="border-b border-gray-200 pb-4 mb-4">
                <p class="font-semibold">{{ $review->user->name }} comentou:</p>
                <p class="italic text-gray-700">{{ $review->descricao }}</p>
                <p class="text-sm text-gray-500">Enviado em {{ $review->created_at->format('d/m/Y') }}</p>
            </div>
        @endforeach
    @endif
    @if($relacionados->isNotEmpty())
        <div class="bg-white p-6 shadow rounded mt-6">
            <h3 class="text-lg font-semibold mb-4">📚 Livros Relacionados</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($relacionados as $livroRel)
                    <div class="border p-3 rounded shadow-sm">
                        <h4 class="font-bold">{{ $livroRel->nome }}</h4>
                        <p class="text-sm text-gray-600">{{ Str::limit($livroRel->bibliografia, 100) }}</p>
                        <a href="{{ route('detalhelivro.show', $livroRel->id) }}" class="text-blue-600 underline mt-2 inline-block">Ver detalhes</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
</x-app-layout>