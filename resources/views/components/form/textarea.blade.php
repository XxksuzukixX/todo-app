<div class="mb-4">
    <label class="block mb-1 font-medium text-gray-700">{{ $label }}</label>
    <textarea 
        name="{{ $name }}" 
        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $attributes }}
    >{{ $value ?? '' }}</textarea>
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>