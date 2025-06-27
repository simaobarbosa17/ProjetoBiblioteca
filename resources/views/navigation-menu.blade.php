<nav x-data="{ open: false, theme: localStorage.getItem('theme') || 'light' }"
     x-init="$watch('theme', value => {
         document.documentElement.setAttribute('data-theme', value);
         localStorage.setItem('theme', value);
     })"
     class="bg-base-100 border-b border-base-300 text-base-content">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo/>
                    </a>
                </div>

                <!-- Navigation Links (without carrinho) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Livros') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.autores') }}" :active="request()->routeIs('admin.autores')">
                                {{ __('Autores') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.editoras') }}" :active="request()->routeIs('admin.editoras')">
                                {{ __('Editoras') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.todasrequesicoes') }}" :active="request()->routeIs('admin.todasrequesicoes')">
                                {{ __('Requisitações') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.reviews') }}" :active="request()->routeIs('admin.reviews')">
                                {{ __('Reviews') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.todasencomendas') }}" :active="request()->routeIs('admin.todasencomendas')">
                                {{ __('Encomendas') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.log') }}" :active="request()->routeIs('admin.log')">
                                {{ __('Logs') }}
                            </x-nav-link>
                        @else
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Livros') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('verequesicao') }}" :active="request()->routeIs('verequesicao')">
                                {{ __('Requisições') }}
                            </x-nav-link>
                            
                        @endif
                    @endauth
                </div>
            </div>

          
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    @if (Auth::user()->role !== 'admin')
                        
                        <a href="{{ route('vercarrinho') }}" class="btn btn-ghost btn-circle" title="Carrinho de Compras" aria-label="Carrinho de Compras">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-base-content" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="7" cy="21" r="2" />
                                <circle cx="17" cy="21" r="2" />
                            </svg>
                        </a>
                    @endif
                @endauth

                <!-- Settings Dropdown -->
                <div class="dropdown dropdown-end" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="btn btn-ghost btn-circle avatar flex items-center gap-2" tabindex="0">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="w-10 rounded-full">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        @else
                            <span class="text-base-content font-medium">{{ Auth::user()->name }}</span>
                        @endif
                        <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-48 space-y-2">
                        <!-- Switcher do Tema -->
                        <li class="flex items-center justify-between px-3 py-2 cursor-pointer select-none"
                            @click="theme = (theme === 'light' ? 'dark' : 'light')"
                            :class="{ 'bg-base-300': theme === 'dark' }" title="Alternar Modo Escuro">
                            <span>Modo Escuro</span>
                            <input type="checkbox" class="toggle toggle-sm" :checked="theme === 'dark'" @click.stop="theme = (theme === 'light' ? 'dark' : 'light')" aria-label="Alternar Modo Escuro" />
                        </li>

                        <li class="menu-title text-xs opacity-50">{{ __('Manage Account') }}</li>
                        <li><a href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li><a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                        @endif

                        <li class="my-2 border-t border-base-200"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="btn btn-square btn-ghost" aria-label="Abrir menu">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" class="sm:hidden bg-base-100 text-base-content border-t border-base-300" x-transition>
        <div class="menu menu-compact p-2 space-y-1">
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Livros') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.autores') }}" :active="request()->routeIs('admin.autores')">
                        {{ __('Autores') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.editoras') }}" :active="request()->routeIs('admin.editoras')">
                        {{ __('Editoras') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.todasrequesicoes') }}" :active="request()->routeIs('admin.todasrequesicoes')">
                        {{ __('Requisitações') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.reviews') }}" :active="request()->routeIs('admin.reviews')">
                        {{ __('Reviews') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.todasencomendas') }}" :active="request()->routeIs('admin.todasencomendas')">
                        {{ __('Encomendas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.log') }}" :active="request()->routeIs('admin.log')">
                        {{ __('Logs') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Livros') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('verequesicao') }}" :active="request()->routeIs('verequesicao')">
                        {{ __('Requisições') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('vercarrinho') }}" :active="request()->routeIs('vercarrinho')" class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                            <circle cx="7" cy="21" r="2" />
                            <circle cx="17" cy="21" r="2" />
                        </svg>
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="border-t border-base-300 pt-4 pb-1">
            <div class="flex items-center px-4 space-x-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="text-sm opacity-70">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="menu menu-compact p-2 mt-3 space-y-1">

                <li class="flex items-center justify-between px-3 py-2 cursor-pointer select-none"
                    @click="theme = (theme === 'light' ? 'dark' : 'light')"
                    :class="{ 'bg-base-300': theme === 'dark' }" title="Alternar Modo Escuro">
                    <span>Modo Escuro</span>
                    <input type="checkbox" class="toggle toggle-sm" :checked="theme === 'dark'" @click.stop="theme = (theme === 'light' ? 'dark' : 'light')" aria-label="Alternar Modo Escuro" />
                </li>

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>