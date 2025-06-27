<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Requisitar Livro: {{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        @if(session('error'))
            <div class="alert alert-error mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('requisicoes.store') }}" method="POST" class="space-y-6p-6 rounded shadow">
            @csrf
            <input type="hidden" name="livros_id" value="{{ $livro->id }}">

            <div>
                <label for="data_requisicao" class="block font-medium">Data da Requisição</label>
                <input type="date" name="data_requisicao" id="data_requisicao"
                    value="{{ old('data_requisicao', now()->format('Y-m-d')) }}" class="input input-bordered w-full" readonly
                    required>
                @error('data_requisicao')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_entrega" class="block font-medium">Data da Entrega</label>
                <input type="date" name="data_entrega" id="data_entrega"
                    value="{{ old('data_entrega', now()->addDays(5)->format('Y-m-d')) }}"
                    class="input input-bordered w-full" readonly required>
                @error('data_entrega')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('dashboard') }}"
                    class="btn btn-outline btn-error transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary hover:bg-blue-700 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Requisitar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>