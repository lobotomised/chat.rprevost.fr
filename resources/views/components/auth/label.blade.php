@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-1 block text-sm font-medium text-gray-800']) }}>
    {{ $value ?? $slot }}
</label>
