<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Editora
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.editoras.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Nome</span>
                                </label>
                                <input type="text" name="nome" class="input input-bordered w-full"
                                    value="{{ old('nome') }}" required />
                                @error('nome')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Logótipo</span>
                            </label>
                            <input type="file" name="logotipo" class="file-input file-input-bordered w-full max-w-xs"
                                accept="image/*" />
                            @error('logotipo')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-between">
                            <button type="submit" class="btn btn-success">
                                ➕ Criar Editora
                            </button>

                            <a href="{{ route('admin.editoras') }}" class="btn btn-outline">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>