<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Livro
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.livros.update', $livro->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">ISBN</span>
                                </label>
                                <input type="text" name="isbn" class="input input-bordered w-full"
                                    value="{{ $livro->isbn }}" required />
                                @error('isbn')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Nome</span>
                                </label>
                                <input type="text" name="nome" class="input input-bordered w-full"
                                    value="{{ $livro->nome }}" required />
                                @error('nome')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Preço (€)</span>
                                </label>
                                <div class="input-group">
                                    <span class="btn btn-square no-animation">€</span>
                                    <input type="number" name="preco" step="0.01" class="input input-bordered w-full"
                                        value="{{ $livro->preco }}" required />
                                </div>
                                @error('preco')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>


                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Editora</span>
                                </label>
                                <select name="editora_id" class="select select-bordered w-full" required>
                                    <option disabled selected>Selecione uma editora</option>
                                    @foreach (\App\Models\Editoras::all() as $editora)
                                        <option value="{{ $editora->id }}" {{ $livro->editora_id == $editora->id ? 'selected' : '' }}>
                                            {{ $editora->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('editora_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>


                        <div class="form-control w-full mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Bibliografia</span>
                            </label>
                            <textarea name="bibliografia"
                                class="textarea textarea-bordered h-24 w-full">{{ $livro->bibliografia }}</textarea>
                            @error('bibliografia')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Autores</span>
                                <span class="label-text-alt text-neutral-500">Selecione múltiplos autores</span>
                            </label>
                            <select name="autores[]" multiple class="select select-bordered w-full h-32"
                                data-tooltip="Segure CTRL para selecionar múltiplos autores">
                                @foreach (\App\Models\Autores::all() as $autor)
                                    <option value="{{ $autor->id }}" {{ $livro->autores->contains($autor->id) ? 'selected' : '' }}>
                                        {{ $autor->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('autores')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>


                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Nova Capa (opcional)</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                @if ($livro->capa)
                                    <div class="avatar">
                                        <div class="w-24 h-32 rounded">
                                              <img src="{{ asset($livro->capa) }}" 
                                                alt="Capa atual" />
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="capa" class="file-input file-input-bordered w-full max-w-xs"
                                    accept="image/*" />
                            </div>
                            @error('capa')
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

                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>