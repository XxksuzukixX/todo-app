<x-app>
    <div class="flex flex-col md:flex-row gap-6">
        
        {{-- カテゴリー --}}
        <aside class="w-full md:w-1/4 bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-4">カテゴリー</h2>
            {{-- カテゴリー追加フォーム --}}
            <form 
                method="POST" 
                action="{{ route('taskType.store') }}"
                class="flex w-full mb-4 rounded overflow-hidden
                    focus-within:ring-2 focus-within:ring-blue-400"
            >
                @csrf
                <input 
                    name="title"
                    type="text"
                    placeholder="カテゴリーを追加..."
                    class="flex-1 min-w-0 border px-3 py-2 focus:outline-none"
                >
                <button class="bg-blue-600 text-white px-4 hover:bg-blue-700">
                    追加
                </button>
            </form>
            <ul class="space-y-2">
                @foreach ($taskTypes as $taskType)
                    <li>
                        <a 
                            href="{{ route('tasks', $taskType->id) }}" 
                            class="flex justify-between items-center px-3 py-2 rounded hover:bg-blue-100"
                        >
                            {{-- カテゴリー名 --}}
                            <span>
                                {{ $taskType->title }}
                            </span>

                            {{-- カウント表示 --}}
                            <div class="flex gap-2 text-sm font-semibold">
                                {{-- doing（緑）--}}
                                @if ($taskType->doing_count > 0)
                                    <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                                        {{ $taskType->doing_count }}
                                    </span>
                                @endif
                                {{-- todo（赤） --}}
                                @if ($taskType->todo_count > 0)
                                    <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
                                        {{ $taskType->todo_count }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        {{-- ダッシュボード --}}
        <section class="flex-1 bg-white rounded shadow p-6">
            {{-- ユーザー表示 --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">ホーム画面</h2>
                <div class="text-gray-600">
                    ようこそ、<span class="font-semibold text-blue-600">
                        {{ Auth::user()->name }}
                    </span> さん
                </div>
            </div>

            {{-- 上部：統計カード --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- 総タスク数 --}}
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-sm text-gray-500">完了タスク数</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $statusCounts['done'] }}</p>
                </div>

                {{-- 完了タスク --}}
                <div class="bg-green-50 p-6 rounded-lg shadow">
                    <h3 class="text-sm text-gray-500">着手中タスク</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $statusCounts['doing'] }}</p>
                </div>

                {{-- 未完了タスク --}}
                <div class="bg-red-50 p-6 rounded-lg shadow">
                    <h3 class="text-sm text-gray-500">未着手タスク</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $statusCounts['todo'] }}</p>
                </div>
            </div>
            {{-- 期日が迫った未着手タスク --}}
            <div class="my-6">
                <h3 class="text-lg font-semibold mb-4">期日が近いタスク</h3>
                <ul class="space-y-2">
                    @forelse ($upcomingTasks as $task)
                        <li class="p-3 border rounded flex justify-between items-center hover:bg-gray-50">
                            {{-- タスク名をクリックすると該当カテゴリーのページへ --}}
                            <a href="{{ route('tasks', $task->task_type_id) }}" class="flex-1">
                                {{ $task->title }}
                            </a>

                            {{-- 締切日 --}}
                            <span class="text-red-600 text-sm font-semibold">
                                期日: {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}
                            </span>
                        </li>
                    @empty
                        <li class="p-3 border rounded text-gray-400">タスクはありません</li>
                    @endforelse
                </ul>
            </div>

            {{-- 最近のタスク --}}
            <div class="my-6">
                <h3 class="text-lg font-semibold mb-4">最近追加したタスク</h3>
                <ul class="space-y-2">
                    @forelse ($recentTasks as $task)
                        <li class="p-3 border rounded flex justify-between items-center hover:bg-gray-50">
                            {{-- タスク名をクリックすると該当カテゴリーのページへ --}}
                            <a href="{{ route('tasks', $task->task_type_id) }}" class="flex-1">
                                {{ $task->title }}
                            </a>
                            
                            {{-- ステータスバッジ --}}
                            @if($task->status == 'done')
                                <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full text-sm">完了</span>
                            @elseif($task->status == 'doing')
                                <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full text-sm">着手中</span>
                            @elseif($task->status == 'todo')
                                <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-sm">未着手</span>
                            @endif
                        </li>
                    @empty
                        <li class="p-3 border rounded text-gray-400">タスクはありません</li>
                    @endforelse
                </ul>
            </div>
        </section>
    </div>
</x-app>