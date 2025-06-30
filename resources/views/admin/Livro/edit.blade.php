<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-base-content">
            Editar Livro
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 shadow-md sm:rounded-lg p-8">
                <form action="{{ route('admin.livros.update', $livro->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                       
                        <div class="form-control w-full">
                            <label for="isbn" class="label">
                                <span class="label-text font-semibold text-base-content">ISBN</span>
                            </label>
                            <input
                                id="isbn"
                                name="isbn"
                                type="text"
                                pattern="[0-9]{13}"
                                minlength="13"
                                maxlength="13"
                                required
                                value="{{ old('isbn', $livro->isbn) }}"
                                placeholder="Ex: 9781234567890"
                                class="input input-bordered w-full"
                                aria-describedby="isbnHelp"
                            />
                            <p id="isbnHelp" class="text-xs mt-1 text-base-content opacity-60">
                                O ISBN deve conter exatamente 13 dígitos numéricos.
                            </p>
                            @error('isbn')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                 
                        <div class="form-control w-full">
                            <label for="nome" class="label">
                                <span class="label-text font-semibold text-base-content">Nome</span>
                            </label>
                            <input
                                id="nome"
                                name="nome"
                                type="text"
                                required
                                value="{{ old('nome', $livro->nome) }}"
                                placeholder="Título do livro"
                                class="input input-bordered w-full"
                            />
                            @error('nome')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div class="form-control w-full">
                            <label for="preco" class="label">
                                <span class="label-text font-semibold text-base-content">Preço (€)</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <span class="btn btn-disabled select-none h-10 px-4 flex items-center justify-center">
                                    €
                                </span>
                                <input
                                    id="preco"
                                    name="preco"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    required
                                    value="{{ old('preco', $livro->preco) }}"
                                    placeholder="0.00"
                                    class="input input-bordered w-full"
                                />
                            </div>
                            @error('preco')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                
                        <div class="form-control w-full">
                            <label for="stock" class="label">
                                <span class="label-text font-semibold text-base-content">Quantidade em Stock</span>
                            </label>
                            <input
                                id="stock"
                                name="stock"
                                type="number"
                                min="0"
                                required
                                value="{{ old('stock', $livro->stock) }}"
                                class="input input-bordered w-full"
                            />
                            @error('stock')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                      
                        <div class="form-control w-full">
                            <label for="editora_id" class="label">
                                <span class="label-text font-semibold text-base-content">Editora</span>
                            </label>
                            <select
                                id="editora_id"
                                name="editora_id"
                                required
                                class="select select-bordered w-full"
                            >
                                <option disabled>Selecione uma editora</option>
                                @foreach (\App\Models\Editoras::all() as $editora)
                                    <option
                                        value="{{ $editora->id }}"
                                        {{ old('editora_id', $livro->editora_id) == $editora->id ? 'selected' : '' }}
                                    >
                                        {{ $editora->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('editora_id')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="form-control w-full mt-6">
                        <label for="bibliografia" class="label">
                            <span class="label-text font-semibold text-base-content">Bibliografia</span>
                        </label>
                        <textarea
                            id="bibliografia"
                            name="bibliografia"
                            rows="4"
                            placeholder="Descrição ou sinopse do livro"
                            class="textarea textarea-bordered w-full resize-none"
                        >{{ old('bibliografia', $livro->bibliografia) }}</textarea>
                        @error('bibliografia')
                            <p class="text-error mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-control w-full mt-6">
                        <label for="autor_ids" class="label flex flex-col gap-1">
                            <span class="label-text font-semibold text-base-content">Autores</span>
                            <span class="text-xs text-base-content opacity-60">Segure CTRL (Cmd no Mac) para selecionar múltiplos autores</span>
                        </label>
                        <select
                            id="autor_ids"
                            name="autor_ids[]"
                            multiple
                            class="select select-bordered w-full h-36"
                            aria-describedby="autorHelp"
                        >
                            @foreach (\App\Models\Autores::all() as $autor)
                                <option
                                    value="{{ $autor->id }}"
                                    {{ collect(old('autor_ids', $livro->autores->pluck('id')->toArray()))->contains($autor->id) ? 'selected' : '' }}
                                >
                                    {{ $autor->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('autor_ids')
                            <p class="text-error mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-6">
                        <label for="capa" class="label">
                            <span class="label-text font-semibold text-base-content">Nova Capa (opcional)</span>
                        </label>

                        <div class="flex items-center gap-4">
                            @if ($livro->capa)
                                <div class="avatar">
                                    <div class="w-24 h-32 rounded">
                                        <img src="{{ asset($livro->capa) }}" alt="Capa atual" />
                                    </div>
                                </div>
                            @endif

                            <input
                                id="capa"
                                name="capa"
                                type="file"
                                accept="image/*"
                                class="file-input file-input-bordered w-full max-w-xs"
                            />
                        </div>

                        @error('capa')
                            <p class="text-error mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

         
                    <div class="mt-8 flex justify-between items-center">
                        <button
                            type="submit"
                            class="btn btn-success flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
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
</x-app-layout>
