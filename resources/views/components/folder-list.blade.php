<aside class="w-full md:w-1/4 bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-4">{{ $title ?? 'フォルダ' }}</h2>
    <ul class="space-y-2">
        @foreach($folders as $folder)
            <li>
                <a href="{{ $folder['link'] }}" class="block px-2 py-1 rounded hover:bg-blue-100">
                    {{ $folder['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        {{ $buttonText ?? '新しいフォルダ' }}
    </button>
</aside>