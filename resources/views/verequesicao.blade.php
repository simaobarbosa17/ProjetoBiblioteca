<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-base-content">Minhas Requisições</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8 space-y-8">
        
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-success text-xl mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20H5a2 2 0 01-2-2V6a2 2 0 012-2h7m0 16h7a2 2 0 002-2V6a2 2 0 00-2-2h-7m0 16V4" />
                    </svg>
                    Requisições Ativas
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($ativas as $requisicao)
                        <div class="card bg-base-200 shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="card-body">
                                <h4 class="card-title text-lg mb-3">{{ $requisicao->livro->nome }}</h4>

                                <div class="flex items-center gap-2 text-sm text-base-content mb-4">
                                    <svg class="w-5 h-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Entrega até: <strong>{{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}</strong></span>
                                </div>

                                <div class="card-actions justify-end">
                                    <form action="{{ route('requisicoes.devolver', $requisicao->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="btn btn-error btn-sm text-white gap-2" 
                                            onclick="return confirm('Tem certeza que deseja devolver este livro?')">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                            Devolver
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert col-span-full">
                            <svg class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Nenhuma requisição ativa no momento.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-error text-xl mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Requisições Devolvidas
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($naoAtivas as $requisicao)
                        <div class="card bg-base-200 shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="card-body">
                                <h4 class="card-title text-lg mb-3">{{ $requisicao->livro->nome }}</h4>

                                <div class="flex items-center gap-2 text-sm text-base-content mb-4">
                                    <svg class="w-5 h-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Devolvido em: <strong>{{ $requisicao->data_devolvida ? \Carbon\Carbon::parse($requisicao->data_devolvida)->format('d/m/Y') : 'Data não disponível' }}</strong></span>
                                </div>

                                @if ($requisicao->review === null)
                                    <div class="bg-base-100 border border-base-300 rounded-lg p-4 mt-4">
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            <h5 class="font-semibold text-base-content">O que achou do livro?</h5>
                                        </div>

                                        <form action="{{ route('reviews.store') }}" method="POST" class="flex flex-col gap-3">
                                            @csrf
                                            <input type="hidden" name="requesicoes_id" value="{{ $requisicao->id }}">
                                            <input type="hidden" name="livros_id" value="{{ $requisicao->livro->id }}">

                                            <textarea 
                                                name="descricao" 
                                                rows="4" 
                                                required 
                                                class="textarea textarea-bordered w-full text-sm focus:outline-none focus:ring-2 focus:ring-primary resize-none" 
                                                placeholder="Conte como foi sua experiência com este livro..."></textarea>

                                            <button type="submit" class="btn btn-primary btn-sm w-full flex justify-center items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                </svg>
                                                Enviar Avaliação
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-success mt-4 p-3">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm">Review publicada! Obrigado por compartilhar sua opinião.</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert col-span-full">
                            <svg class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Nenhuma requisição finalizada ainda.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>









