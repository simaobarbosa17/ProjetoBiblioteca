@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary text-primary text-base font-medium bg-base-200 focus:outline-none focus:border-primary transition duration-150 ease-in-out'
    : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-base-content hover:bg-base-300 hover:border-primary focus:outline-none focus:bg-base-300 focus:border-primary transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>