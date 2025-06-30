<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            Criar Editora
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
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

                         <div class="mt-8 flex justify-between items-center">
                            <button
                                type="submit"
                                class="btn btn-success flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Criar Editora
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