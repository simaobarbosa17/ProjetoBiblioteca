<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                📋 {{ __('Avaliações Pendentes') }}
            </h2>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total de Avaliações Pendentes</div>
                    <div class="stat-value text-primary">{{ $reviews->total() }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($reviews->isEmpty())
                <div class="p-6 shadow rounded text-center">
                    Nenhuma avaliação pendente para aprovar.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($reviews as $review)
                        <div class="shadow rounded p-6 space-y-4 flex flex-col justify-between h-full">
                            <div class="space-y-2">
                                <p><strong>Utilizador:</strong> {{ $review->user->name }}</p>
                                <p><strong>Livro:</strong> {{ $review->livro->nome }}</p>
                                <p><strong>Comentário:</strong> {{ $review->descricao }}</p>
                            </div>

                            <div class="flex flex-col space-y-3 mt-4">
                                <form action="{{ route('admin.reviews.aprovar', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm w-full flex justify-center items-center gap-2">
                                        ✅ Aprovar
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.recusar', $review->id) }}" method="POST" class="flex flex-col space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="justificacao" class="textarea textarea-bordered w-full resize-none" rows="3" placeholder="Justificativa para recusar" required></textarea>
                                    <button type="submit" class="btn btn-error btn-sm w-full flex justify-center items-center gap-2">
                                        ❌ Recusar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    {{ $reviews->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>