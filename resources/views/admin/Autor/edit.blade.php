<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-base-content">
            Editar Autor
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 shadow-md sm:rounded-lg p-8">
                <form action="{{ route('admin.autores.update', $autor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <div class="form-control w-full">
                            <label for="nome" class="label">
                                <span class="label-text font-semibold text-base-content">Nome</span>
                            </label>
                            <input
                                id="nome"
                                name="nome"
                                type="text"
                                required
                                value="{{ old('nome', $autor->nome) }}"
                                placeholder="Nome do autor"
                                class="input input-bordered w-full"
                            />
                            @error('nome')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-control w-full">
                            <label for="foto" class="label">
                                <span class="label-text font-semibold text-base-content">Nova Foto (opcional)</span>
                            </label>

                            <div class="flex items-center gap-4">
                                <div class="avatar">
                                    <div class="w-24 h-32 rounded">
                                        <img src="{{ Storage::url(str_replace('storage/app/public/', '', $autor->foto)) }}"
                                                    alt="Foto atual" />
                                    </div>
                                </div>

                                <input
                                    id="foto"
                                    name="foto"
                                    type="file"
                                    accept="image/*"
                                    class="file-input file-input-bordered w-full max-w-xs"
                                />
                            </div>
                            @error('foto')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

 
                    <div class="mt-8 flex justify-between items-center">
                        <button
                            type="submit"
                            class="btn btn-success flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Salvar Alterações
                        </button>

                        <a href="{{ route('admin.autores') }}" class="btn btn-outline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

