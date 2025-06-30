<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeSwitcher()" x-init="initTheme()" :data-theme="theme">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Gestão de uma Biblioteca') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="bg-base-100 text-base-content font-sans flex flex-col" style="min-height: 100vh;">

    @auth
        <x-banner />
        @livewire('navigation-menu')
    @else
        <div class="p-4 flex justify-end">
            <button 
                @click="theme = theme === 'light' ? 'dark' : 'light'" 
                class="btn btn-ghost btn-circle hover:bg-base-200 transition-colors" 
                aria-label="Alternar Tema">
                <svg x-show="theme === 'light'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
        </div>
    @endauth

    @if (isset($header))
        <header class="bg-base-200 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="flex-grow py-10 max-w-7xl mx-auto px-6 lg:px-8 w-full">
        {{ $slot }}
    </main>

    <footer class="footer footer-center p-6 bg-base-200 text-base-content shadow-inner mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <p>© {{ date('Y') }} Gestão de uma Biblioteca. Todos os direitos reservados.</p>

            <div class="flex gap-6 text-xl">
                <a href="https://github.com/simaobarbosa17/ProjetoBiblioteca.git" target="_blank" rel="noopener noreferrer" aria-label="GitHub" class="hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.372 0 0 5.372 0 12a12 12 0 008.21 11.44c.6.11.82-.26.82-.58v-2.17c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.33-1.77-1.33-1.77-1.09-.75.08-.74.08-.74 1.2.09 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48.99.11-.77.42-1.3.76-1.6-2.67-.3-5.48-1.34-5.48-5.97 0-1.32.47-2.4 1.24-3.24-.12-.3-.54-1.52.12-3.17 0 0 1.01-.32 3.3 1.23a11.46 11.46 0 016 0c2.3-1.55 3.3-1.23 3.3-1.23.66 1.65.24 2.87.12 3.17.78.84 1.24 1.92 1.24 3.24 0 4.64-2.82 5.66-5.5 5.97.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.83.58A12 12 0 0024 12c0-6.628-5.372-12-12-12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    @stack('modals')
    @livewireScripts

    <script>
        function themeSwitcher() {
            return {
                theme: 'light',
                initTheme() {
                    this.theme = localStorage.getItem('theme') || 'light';
                    document.documentElement.setAttribute('data-theme', this.theme);
                },
                toggleTheme() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    document.documentElement.setAttribute('data-theme', this.theme);
                }
            }
        }
    </script>
</body>
</html>