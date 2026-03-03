<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Todo App' }}</title>
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-900">
    <!-- ヘッダー -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">Todo App</h1>
            <nav class="flex">
                {{-- ログイン済みの場合 --}}
                @auth
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 px-3">ホーム</a>

                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600 px-3 bg-transparent border-0 cursor-pointer">
                            ログアウト
                        </button>
                    </form>
                @endauth

                {{-- ゲストの場合 --}}
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3">ログイン</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 px-3">新規登録</a>
                @endguest
            </nav>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="container mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    <!-- フッター -->
    <footer class="bg-white shadow mt-8">
        <div class="container mx-auto px-4 py-4 text-center text-gray-500 text-sm">
            &copy; 2026 RAMP
        </div>
    </footer>
</body>
</html>