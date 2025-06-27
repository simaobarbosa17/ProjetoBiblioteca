<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Finalizar Compra
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Resumo da Compra</h3>

            <ul class="divide-y divide-gray-200 mb-6">
                @foreach($carrinho as $item)
                    <li class="py-3 flex justify-between items-center">
                          <span>{{ $item->livro->nome }} (x{{ $item->quantidade }})</span>
                         <span>
                            €{{ number_format($item->livro->preco, 2, ',', '.') }} 
                            &times; {{ $item->quantidade }} = 
                            <strong>€{{ number_format($item->livro->preco * $item->quantidade, 2, ',', '.') }}</strong>
                        </span>
                    </li>
                @endforeach
            </ul>

            <div class="text-right text-xl font-semibold text-green-700 mb-6">
                Total: €{{ number_format($total, 2, ',', '.') }}
            </div>

            <form action="{{ route('carrinho.processar') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="morada" class="block font-medium text-sm">Morada de Entrega</label>
                    <textarea id="morada" name="morada" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('morada') }}</textarea>
                </div>
                @if(session('erro'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        {{ session('erro') }}
                    </div>
                @endif
                <button type="submit"
                        class="btn btn-primary text-black px-6 py-2 rounded shadow font-medium">
                    Pagar 
                </button>
            </form>
        </div>
    </div>
</x-app-layout>