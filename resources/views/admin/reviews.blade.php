<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Avaliações Pendentes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($reviews->isEmpty() )
                <p class="text-gray-600">Nenhuma avaliação pendente para aprovar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="table w-full table-zebra">
                        <thead>
                            <tr class="bg-base-200 text-base-content">
                                <th>Usuário</th>
                                <th>Livro</th>
                                <th>Comentário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ $review->livro->nome }}</td>
                                    <td>{{ $review->descricao }}</td>
                                    <td>
                                        @if (!$review->validado && is_null($review->justificacao))
                                            <form action="{{ route('admin.reviews.aprovar', $review->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    ✅ Aprovar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                     <td>
                                        @if ($review->justificacao)
                                            <div class="text-sm text-red-600">
                                                <strong>Justificação:</strong> {{ $review->justificacao }}
                                            </div>
                                        @elseif (!$review->validado)
                                            <form action="{{ route('admin.reviews.recusar', $review->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('PATCH')

                                                <textarea name="justificacao" class="textarea textarea-bordered w-full" rows="2" placeholder="Justificativa para recusar" required></textarea>

                                                <button type="submit" class="btn btn-error btn-sm mt-2">❌ Recusar</button>
                                            </form>
                                        @endif
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>