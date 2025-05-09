<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-center gap-6">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-8 py-3 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-md text-lg font-medium leading-normal transition-all duration-200 hover:bg-[#f5f5f3]">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-8 py-3 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-md text-lg font-medium leading-normal transition-all duration-200 hover:bg-[#f5f5f3]">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-8 py-3 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-md text-lg font-medium leading-normal transition-all duration-200 hover:bg-[#f5f5f3]">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>


    @if (Route::has('login'))
        <div class="h-14 hidden lg:block"></div>
    @endif
</body>

</html>