<x-app>
    <div class="max-w-md mx-auto mt-12 bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">新規登録</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <x-form.input 
                name="name" 
                label="名前" 
                type="text" 
                placeholder="山田 太郎" 
                required 
            />

            <x-form.input 
                name="email" 
                label="メールアドレス" 
                type="email" 
                placeholder="example@example.com" 
                required 
            />

            <x-form.input 
                name="password" 
                label="パスワード" 
                type="password" 
                placeholder="パスワード" 
                required 
            />

            <x-form.input 
                name="password_confirmation" 
                label="パスワード確認" 
                type="password" 
                placeholder="パスワード確認" 
                required 
            />

            <x-form.button color="blue" class="w-full">登録</x-form.button>
        </form>

        <div class="mt-4 text-center text-gray-600 text-sm">
            すでにアカウントをお持ちですか？ 
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">ログインはこちら</a>
        </div>
    </div>
</x-app>