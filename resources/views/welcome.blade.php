<x-app-layout>
    <main class="flex-grow">
        <div class="hero min-h-screen bg-gradient-to-br from-base-200 to-base-300">
            <div class="hero-content text-center">
                <div class="max-w-6xl px-6">
                    <h2 class="text-2xl font-bold text-base-content">
                        📚 {{ __('Gestão de uma Biblioteca') }}
                    </h2>
                    <p class="text-lg text-base-content/70 font-medium">
                         Plataforma Inteligente de Gestão
                    </p>
                    <br>
                    <br>


                   
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-20">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ Auth::user()->role === 'admin' ? url('/admin/dashboard') : url('/dashboard') }}"
                                    class="btn btn-primary btn-lg px-12 hover:scale-105 transition-transform shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Ir para Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="btn btn-outline btn-primary btn-lg px-12 hover:scale-105 transition-transform shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Entrar
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="btn btn-primary btn-lg px-12 hover:scale-105 transition-transform shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Registar 
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                    <br>
                    <br>
                 
                   
                    <section class="py-20 bg-base-100 w-full rounded-lg">
                        <div class="container mx-auto px-12">
                            <div class="text-center mb-20">
                                <h2 class="text-4xl font-bold mb-4">Funcionalidades Principais</h2>
                                <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                                    Ferramentas dedicadas para Administradores e Clientes para gerir a biblioteca com eficiência.
                                </p>
                            </div>

                            
                            <div class="space-y-16">
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-20">
                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-primary text-primary-content rounded-full w-16">
                                                    <span class="text-2xl">👥</span>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="card-body items-center text-center">
                                            <h2 class="card-title text-primary">Gestão de Utilizadores (Admin)</h2>
                                            <p>Registo e autenticação, perfis de utilizador e permissões para controle seguro do sistema.</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Registo</div>
                                                <div class="badge badge-outline">Autenticação</div>
                                                <div class="badge badge-outline">Permissões</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-secondary text-secondary-content rounded-full w-16">
                                                    <span class="text-2xl">📚</span>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="card-body items-center text-center">
                                            <h2 class="card-title text-secondary">Gestão de Livros (Admin)</h2>
                                            <p>Adicionar, editar e remover livros, além de controlar a disponibilidade em stock.</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Adicionar</div>
                                                <div class="badge badge-outline">Editar</div>
                                                <div class="badge badge-outline">Stock</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-accent text-accent-content rounded-full w-16">
                                                    <span class="text-2xl">📊</span>
                                                </div>
                                            </div>
                                        </figure>
                                         <div class="card-body items-center text-center">
                                            <h2 class="card-title text-success">Relatórios (Admin)</h2>
                                            <p>Estatísticas detalhadas sobre requisições, encomendas, logs para análise e planeamento.</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Estatísticas</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-20">
                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-info text-info-content rounded-full w-16">
                                                    <span class="text-2xl">📦</span>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="card-body items-center text-center">
                                            <h2 class="card-title text-info">Compra (Clientes)</h2>
                                            <p>Solicitação de novas aquisições de livros</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Aquisições</div>
                                                <div class="badge badge-outline">Pedidos</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-success text-success-content rounded-full w-16">
                                                    <span class="text-2xl">📝</span>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="card-body items-center text-center">
                                            <h2 class="card-title text-accent">Requisições (Clientes)</h2>
                                            <p>Criar e listar requisições, além de marcar devoluções de forma simples.</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Criar</div>
                                                <div class="badge badge-outline">Listar</div>
                                                <div class="badge badge-outline">Devoluções</div>
                                            </div>
                                        </div>
                                       
                                    </div>

                                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 p-4">
                                        <figure class="px-10 pt-10">
                                            <div class="avatar placeholder">
                                                <div class="bg-warning text-warning-content rounded-full w-16">
                                                    <span class="text-2xl">⭐</span>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="card-body items-center text-center">
                                            <h2 class="card-title text-warning">Reviews (Clientes)</h2>
                                            <p>Avaliações e comentários sobre livros lidos pelos utilizadores da biblioteca.</p>
                                            <div class="card-actions justify-center">
                                                <div class="badge badge-outline">Avaliações</div>
                                                <div class="badge badge-outline">Comentários</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <br>
                    
                    <div class="flex flex-wrap gap-2 justify-center mt-20">
                        <div class="badge badge-outline badge-lg">Laravel</div>
                        <div class="badge badge-outline badge-lg">DaisyUI</div>
                        <div class="badge badge-outline badge-lg">Tailwind CSS</div>
                        <div class="badge badge-outline badge-lg">SqLite</div>
                        <div class="badge badge-outline badge-lg">Livewire</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>