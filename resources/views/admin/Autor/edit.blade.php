<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Autor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.autores.update', $autor->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">




                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Nome</span>
                                </label>
                                <input type="text" name="nome" class="input input-bordered w-full"
                                    value="{{ $autor->nome }}" required />
                                @error('nome')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                            <div class="form-control mt-4">
                                <label class="label">
                                    <span class="label-text font-medium">Nova Foto (opcional)</span>
                                </label>
                                <div class="flex items-center space-x-4">
                                    @if ($autor->foto)
                                        <div class="avatar">
                                            <div class="w-24 h-32 rounded">
                                                <img src="{{ Storage::url(str_replace('storage/app/public/', '', $autor->foto)) }}"
                                                    alt="Foto atual" />
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="foto"
                                        class="file-input file-input-bordered w-full max-w-xs" accept="image/*" />
                                </div>
                                @error('foto')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                            <div class="mt-6 flex justify-between">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
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
    </div>
</x-app-layout>