<x-mail::layout>


<x-slot:header>
    <x-mail::header :url="config('app.url')" style="display: flex; align-items: center; gap: 12px;">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="40" height="40" viewBox="0 0 24 24" 
             fill="none" stroke="#6366F1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                     C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                     C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13
                     C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>

        
        <span style="font-size: 1.25rem; font-weight: bold; color: #1F2937;">
            Biblioteca Virtual
        </span>
    </x-mail::header>
</x-slot:header>


{!! $slot !!}


@isset($subcopy)
    <x-slot:subcopy>
        <x-mail::subcopy>
            {!! $subcopy !!}
        </x-mail::subcopy>
    </x-slot:subcopy>
@endisset

<x-slot:footer>
    <x-mail::footer>
        © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.<br>
        Obrigado por utilizar nosso sistema de biblioteca.
    </x-mail::footer>
</x-slot:footer>

</x-mail::layout>
