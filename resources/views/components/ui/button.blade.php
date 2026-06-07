@props(['type' => 'primary'])

@php
$base = "px-4 py-2 rounded-xl text-sm font-medium transition";

$styles = match($type) {
    'primary' => "bg-pink-600 text-white hover:bg-pink-700",
    'secondary' => "border border-gray-300 text-gray-700 hover:bg-gray-100",
    'danger' => "bg-red-500 text-white hover:bg-red-600",
    default => "bg-pink-600 text-white hover:bg-pink-700",
};
@endphp

<button {{ $attributes->merge(['class' => $base.' '.$styles]) }}>
    {{ $slot }}
</button>