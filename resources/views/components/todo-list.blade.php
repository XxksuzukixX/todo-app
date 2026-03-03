<section class="flex-1 bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-4">{{ $title ?? 'タスク' }}</h2>

    <!-- タスク追加フォーム -->
    <form class="flex mb-4">
        <input type="text" name="title" placeholder="タスクを追加..." 
               class="flex-1 border rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700">追加</button>
    </form>

    <!-- タスク一覧 -->
    <ul class="space-y-2">
        @foreach($tasks as $task)
            <li class="flex justify-between items-center p-2 border rounded hover:bg-gray-50">
                <span>{{ $task['title'] }}</span>
                <div>
                    <button class="text-green-600 hover:text-green-800 px-2">完了</button>
                    <button class="text-red-600 hover:text-red-800 px-2">削除</button>
                </div>
            </li>
        @endforeach
    </ul>
</section>