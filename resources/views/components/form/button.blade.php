<button type="{{ $type ?? 'submit' }}" 
        class="bg-{{ $color ?? 'blue' }}-600 text-white px-4 py-2 rounded hover:bg-{{ $color ?? 'blue' }}-700 {{ $class ?? '' }}">
    {{ $slot }}
</button>