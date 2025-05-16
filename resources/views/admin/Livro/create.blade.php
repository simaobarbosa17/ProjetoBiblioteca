<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Livro
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.livros.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">ISBN</span>
                                </label>
                                <input type="text" name="isbn" class="input input-bordered w-full"
                                    value="{{ old('isbn') }}" required pattern="[0-9]{13}" minlength="13" maxlength="13"
                                    title="O ISBN deve conter exatamente 13 dígitos numéricos" />
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
                                    value="{{ old('nome') }}" required />
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
                                        value="{{ old('preco') }}" required />
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
                                        <option value="{{ $editora->id }}" {{ old('editora_id') == $editora->id ? 'selected' : '' }}>
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
                                class="textarea textarea-bordered h-24 w-full">{{ old('bibliografia') }}</textarea>
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
                            <select name="autor_ids[]" multiple class="select select-bordered w-full h-32"
                                data-tooltip="Segure CTRL para selecionar múltiplos autores">
                                @foreach (\App\Models\Autores::all() as $autor)
                                    <option value="{{ $autor->id }}" {{ collect(old('autor_ids'))->contains($autor->id) ? 'selected' : '' }}>
                                        {{ $autor->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('autor_ids')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Capa</span>
                            </label>
                            <input type="file" name="capa" class="file-input file-input-bordered w-full max-w-xs"
                                accept="image/*" />
                            @error('capa')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-between">
                            <button type="submit" class="btn btn-success">
                                ➕ Criar Livro
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