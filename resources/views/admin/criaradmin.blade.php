<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Novo Administrador
        </h2>
    </x-slot>




    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.store') }}">
        @csrf

        <div>
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
        </div>

        <div class="mt-4">
            <x-label for="password" value="{{ __('Password') }}" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
        </div>

        <div class="mt-4">
            <x-label for="password_confirmation" value="{{ __('Confirmar Password') }}" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                required />
        </div>
        <div class="flex items-center justify-end mt-4">

            <x-button class="ms-4">
                {{ __('Criar Admin') }}
            </x-button>
        </div>
    </form>


</x-app-layout>