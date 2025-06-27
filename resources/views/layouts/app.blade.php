<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeSwitcher()" x-init="initTheme()" :data-theme="theme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-base-100 text-base-content font-sans">
        <x-banner />
        <div class="min-h-screen">
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="bg-base-200 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="py-10">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>

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