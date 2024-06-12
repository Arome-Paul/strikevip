<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-blue-800 rounded-lg p-3 font-semibold text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500']) }}>
    {{ $slot }}
</button>