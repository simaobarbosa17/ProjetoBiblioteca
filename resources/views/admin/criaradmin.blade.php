<x-app-layout>
   
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                👤  {{ __('Criar Novo Administrador') }}
            </h2>
        </div>
    </x-slot>
 
  
    <div class="py-6 px-4 max-w-md mx-auto space-y-6">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-sm">
                <div>
                    <h3 class="font-bold">Ocorreram erros:</h3>
                    <ul class="list-disc list-inside text-sm mt-1 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

     
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-4  max-w-md">
                <form method="POST" action="{{ route('admin.store') }}" class="space-y-4">
                    @csrf

                  
                    <div class="form-control">
                        <label for="email" class="label">
                            <span class="label-text font-semibold">Email</span>
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="input input-bordered w-full"
                        />
                    </div>

                    
                    <div class="form-control">
                        <label for="password" class="label">
                            <span class="label-text font-semibold">Password</span>
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="input input-bordered w-full"
                        />
                    </div>

                    
                    <div class="form-control">
                        <label for="password_confirmation" class="label">
                            <span class="label-text font-semibold">Confirmar Password</span>
                        </label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="input input-bordered w-full"
                        />
                    </div>

                  
                    <div class="form-control mt-2">
                        <button type="submit" class="btn btn-primary w-full">
                            Criar Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
