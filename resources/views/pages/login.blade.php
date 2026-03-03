<x-app>
    <div class="max-w-md mx-auto mt-12 bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">ログイン</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

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

            <x-form.button color="blue" class="w-full">ログイン</x-form.button>
        </form>

        <div class="mt-4 text-center text-gray-600 text-sm">
            新規登録は <a href="{{ route('register') }}" class="text-blue-600 hover:underline">こちら</a>
        </div>
    </div>
</x-app>