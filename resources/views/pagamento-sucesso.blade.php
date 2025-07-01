<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 rounded-xl shadow-md text-center">
        <h1 class="text-2xl font-bold text-green-600">Pagamento realizado com sucesso!</h1>
        <p class="mt-4 ">Sua compra foi confirmada e será processada em breve.</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Voltar para o início
        </a>
    </div>
</x-app-layout>