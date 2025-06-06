<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Finalizar Compra
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Resumo da Compra</h3>

            <ul class="divide-y divide-gray-200 mb-6">
                @foreach($carrinho as $item)
                    <li class="py-3 flex justify-between items-center">
                        <span>{{ $item->livro->nome }}</span>
                        <span>€{{ number_format($item->livro->preco, 2, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="text-right text-xl font-semibold text-green-700 mb-6">
                Total: €{{ number_format($total, 2, ',', '.') }}
            </div>

            <form action="{{ route('carrinho.processar') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="morada" class="block font-medium text-sm text-gray-700">Morada de Entrega</label>
                    <textarea id="morada" name="morada" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('morada') }}</textarea>
                </div>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-2 rounded shadow font-medium">
                    Pagar com Stripe
                </button>
            </form>
        </div>
    </div>
</x-app-layout>