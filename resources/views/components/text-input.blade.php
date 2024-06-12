@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg']) !!}>
