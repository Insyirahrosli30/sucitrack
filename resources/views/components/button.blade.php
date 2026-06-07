<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-pink-300 to-purple-300 hover:from-pink-400 hover:to-purple-400 border-0 rounded-xl font-semibold text-gray-800 uppercase tracking-wider shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2'
    ]) }}
>
    {{ $slot }}
</button>