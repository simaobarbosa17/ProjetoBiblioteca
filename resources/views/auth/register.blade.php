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
                <h2 class="text-xl font-bold text-base-content">Criar Conta</h2>
                <p class="text-sm text-base-content/70">Preencha os campos abaixo para se registrar</p>
            </div>

            <div class="card bg-base-100 shadow-md">
                <div class="card-body p-5">

                  
                    @if ($errors->any())
                        <div class="alert alert-error mb-4">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                 
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Nome completo</span>
                            </label>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                class="input input-bordered w-full @error('name') input-error @enderror" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                            />
                        </div>

                      
                        <div class="form-control">
                            <label for="email" class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                class="input input-bordered w-full @error('email') input-error @enderror" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="username"
                            />
                        </div>

                       
                        <div class="form-control">
                            <label for="password" class="label">
                                <span class="label-text">Senha</span>
                            </label>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                class="input input-bordered w-full @error('password') input-error @enderror" 
                                required 
                                autocomplete="new-password"
                            />
                        </div>

                      
                        <div class="form-control">
                            <label for="password_confirmation" class="label">
                                <span class="label-text">Confirmar Senha</span>
                            </label>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                class="input input-bordered w-full" 
                                required 
                                autocomplete="new-password"
                            />
                        </div>

                        
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="form-control">
                                <label class="cursor-pointer flex items-start gap-2">
                                    <input type="checkbox" name="terms" id="terms" class="checkbox checkbox-primary mt-1" required />
                                    <span class="label-text text-sm">
                                        Eu concordo com os 
                                        <a href="{{ route('terms.show') }}" target="_blank" class="link link-hover link-primary">Termos de Serviço</a> 
                                        e com a 
                                        <a href="{{ route('policy.show') }}" target="_blank" class="link link-hover link-primary">Política de Privacidade</a>.
                                    </span>
                                </label>
                            </div>
                        @endif

                       
                        <div class="flex items-center justify-between pt-2">
                            <a href="{{ route('login') }}" class="link link-primary text-sm">
                                Já tem uma conta?
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Registrar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
