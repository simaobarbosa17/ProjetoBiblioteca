<nav
    x-data="{
        open: false,
        theme: ['light', 'dark'].includes(localStorage.getItem('theme')) ? localStorage.getItem('theme') : 'light',
        userDropdown: false
    }"
    x-init="$watch('theme', value => {
        document.documentElement.setAttribute('data-theme', value);
        localStorage.setItem('theme', value);
    })"
    @keydown.escape.window="open = false; userDropdown = false"
    class="bg-base-100/95 backdrop-blur-md border-b border-base-300/50 text-base-content sticky top-0 z-50 shadow-sm">

  
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center hover:opacity-80 transition-opacity group">
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <div class="relative">
                                    <svg class="h-10 w-10 text-primary group-hover:text-primary-focus transition-colors" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"/>
                                    </svg>
                                    <div class="absolute -top-1 -right-1 bg-primary text-primary-content rounded-full w-4 h-4 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            @else
                              
                                <div class="relative">
                                    <svg class="h-10 w-10 text-primary group-hover:text-primary-focus transition-colors" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                   
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-1 h-6 bg-primary/30 rounded-full"></div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                        
                        <div class="ml-3 hidden lg:block">
                            <span class="text-lg font-bold text-base-content group-hover:text-primary transition-colors">
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        BiblioAdmin
                                    @else
                                        BiblioTeca
                                    @endif
                                @else
                                    BiblioTeca
                                @endauth
                            </span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex md:items-center md:ml-8 space-x-1">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <div class="flex space-x-1">
                                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" 
                                    class="px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ __('Livros') }}
                                </x-nav-link>
                                
                                <x-nav-link href="{{ route('admin.autores') }}" :active="request()->routeIs('admin.autores')"
                                    class="px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('Autores') }}
                                </x-nav-link>
                                
                                <x-nav-link href="{{ route('admin.editoras') }}" :active="request()->routeIs('admin.editoras')"
                                    class="px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ __('Editoras') }}
                                </x-nav-link>
                                <div class="dropdown dropdown-hover">
                                    <label tabindex="0" class="btn btn-ghost px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Gestão
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-lg w-52 border border-base-300">
                                        <li>
                                            <a href="{{ route('admin.todasrequesicoes') }}" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                                </svg>
                                                {{ __('Requisições') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.reviews') }}" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                                {{ __('Reviews') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.todasencomendas') }}" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                {{ __('Encomendas') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.log') }}" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                {{ __('Logs') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>  
                        @else
                            <div class="flex space-x-1">
                                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                                    class="px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ __('Livros') }}
                                </x-nav-link>
                                
                                <x-nav-link href="{{ route('verequesicao') }}" :active="request()->routeIs('verequesicao')"
                                    class="px-4 py-2 rounded-lg hover:bg-base-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                    {{ __('Requisições') }}
                                </x-nav-link>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>


         
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    @if (Auth::user()->role !== 'admin')
                      
                        <a href="{{ route('vercarrinho') }}" class="btn btn-ghost btn-circle relative hover:bg-base-200 transition-colors" aria-label="Carrinho">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="7" cy="21" r="2" />
                                <circle cx="17" cy="21" r="2" />
                            </svg>
                        </a>
                    @endif

                 
                    <button @click="theme = theme === 'light' ? 'dark' : 'light'" class="btn btn-ghost btn-circle hover:bg-base-200 transition-colors" aria-label="Alternar Tema">
                        <svg x-show="theme === 'light'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    
                    <div class="relative" x-data>
                        <button @click="userDropdown = !userDropdown" class="avatar btn btn-ghost btn-circle">
                            <div class="w-8 rounded-full">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        </button>

                        <div x-show="userDropdown" x-cloak @click.outside="userDropdown = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="absolute right-0 mt-2 w-48 bg-base-100 border border-base-300 rounded-lg shadow-lg z-50">
                            <div class="p-3 border-b border-base-300">
                                <p class="font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-sm opacity-70 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1 text-sm">
                                <li>
                                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-base-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ __('Perfil') }}
                                    </a>
                                </li>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <li>
                                        <a href="{{ route('api-tokens.index') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-base-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            {{ __('API Tokens') }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-error hover:bg-error/10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            {{ __('Sair') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>  
                @endauth
            </div>
            <div class="md:hidden flex items-center space-x-2">
                @auth
                    @if (Auth::user()->role !== 'admin')
                        <a href="{{ route('vercarrinho') }}" class="btn btn-ghost btn-sm btn-circle" title="Carrinho">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="7" cy="21" r="2" />
                                <circle cx="17" cy="21" r="2" />
                            </svg>
                        </a>
                    @endif
                @endauth
                
                <button @click="open = !open" class="btn btn-ghost btn-sm btn-square" aria-label="Menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-base-100 border-t border-base-300 shadow-lg">
        
        <div class="px-4 py-3 space-y-2">
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ __('Livros') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link href="{{ route('admin.autores') }}" :active="request()->routeIs('admin.autores')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('Autores') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link href="{{ route('admin.editoras') }}" :active="request()->routeIs('admin.editoras')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ __('Editoras') }}
                    </x-responsive-nav-link>
                    
                    <div class="pt-2">
                        <div class="text-xs font-semibold uppercase tracking-wide text-base-content/60 mb-2 px-3">Gestão</div>
                        <x-responsive-nav-link href="{{ route('admin.todasrequesicoes') }}" :active="request()->routeIs('admin.todasrequesicoes')" class="flex items-center gap-3 p-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            {{ __('Requisições') }}
                        </x-responsive-nav-link>
                        
                        <x-responsive-nav-link href="{{ route('admin.reviews') }}" :active="request()->routeIs('admin.reviews')" class="flex items-center gap-3 p-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ __('Reviews') }}
                        </x-responsive-nav-link>
                        
                        <x-responsive-nav-link href="{{ route('admin.todasencomendas') }}" :active="request()->routeIs('admin.todasencomendas')" class="flex items-center gap-3 p-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            {{ __('Encomendas') }}
                        </x-responsive-nav-link>
                        
                        <x-responsive-nav-link href="{{ route('admin.log') }}" :active="request()->routeIs('admin.log')" class="flex items-center gap-3 p-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('Logs') }}
                        </x-responsive-nav-link>
                    </div>
                @else
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ __('Livros') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link href="{{ route('verequesicao') }}" :active="request()->routeIs('verequesicao')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        {{ __('Requisições') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link href="{{ route('vercarrinho') }}" :active="request()->routeIs('vercarrinho')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                            <circle cx="7" cy="21" r="2" />
                            <circle cx="17" cy="21" r="2" />
                        </svg>
                        {{ __('Carrinho') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="border-t border-base-300 px-4 py-4">
            <div class="flex items-center space-x-3 mb-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="avatar">
                        <div class="w-12 h-12 rounded-full ring-2 ring-base-300 overflow-hidden">
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full object-cover" />
                        </div>
                    </div>
                @else
                    <div class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-12 h-12">
                            <span class="text-lg font-medium">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-base truncate">{{ Auth::user()->name }}</div>
                    <div class="text-sm opacity-70 truncate">{{ Auth::user()->email }}</div>
                    @if (Auth::user()->role === 'admin')
                        <div class="badge badge-primary badge-sm mt-1">Admin</div>
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-base-200 transition-colors mb-2"
                 @click="theme = (theme === 'light' ? 'dark' : 'light')">
                <div class="flex items-center gap-3">
                    <svg x-show="theme === 'light'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Modo Escuro</span>
                </div>
                <input type="checkbox" 
                       class="toggle toggle-sm" 
                       :checked="theme === 'dark'" 
                       @click.stop="theme = (theme === 'light' ? 'dark' : 'light')" 
                       aria-label="Alternar Modo Escuro" />
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="flex items-center gap-3 p-3 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="flex items-center gap-3 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" 
                                         @click.prevent="$root.submit();" 
                                         class="flex items-center gap-3 p-3 rounded-lg text-error hover:bg-error/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

    

