@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-700 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
