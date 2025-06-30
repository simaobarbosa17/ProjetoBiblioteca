<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200 py-10 px-4">
        <div class="w-full max-w-sm space-y-6">
            <div class="text-center">
             
                <div class="mx-auto h-16 w-16 mb-4">
                    <svg viewBox="0 0 24 24" class="w-full h-full text-primary" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" opacity="0.3"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-base-content">Recuperar Senha</h2>
                <p class="text-sm text-base-content/70">
                    Informe seu e-mail para receber o link de redefinição de senha.
                </p>
            </div>

            <div class="card bg-base-100 shadow-md">
                <div class="card-body p-5">

               
                    @session('status')
                        <div class="alert alert-success mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $value }}</span>
                        </div>
                    @endsession

               
                    @if ($errors->any())
                        <div class="alert alert-error mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <ul class="list-disc list-inside text-sm mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf

                      
                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text font-medium">Email</span>
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="input input-bordered w-full @error('email') input-error @enderror"
                                placeholder="seu@email.com"
                                required 
                                autofocus 
                                autocomplete="username"
                            />
                        </div>

                        <div class="form-control mt-4">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Enviar link de redefinição
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
