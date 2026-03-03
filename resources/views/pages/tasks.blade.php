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

        {{-- タスク一覧 --}}
        <section class="flex-1 bg-white rounded shadow p-4">
            <div 
                class="flex mb-4" 
                x-data="{ isEditOpen: false }"
            >
                <h2 class="text-lg font-semibold ">{{$selectedType->title}}</h2>
                {{-- 編集ボタン（鉛筆アイコン） --}}
                <button 
                    class="ml-auto text-gray-500 hover:text-gray-700 p-1 rounded-full"
                    x-on:click="isEditOpen = true"
                    title="編集"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M16.5 3.5l4 4L12 16l-4 1 1-4 8.5-8.5z" />
                    </svg>
                </button>
                {{-- 削除ボタン（ゴミ箱アイコン） --}}
                <form method="POST" action="{{ route('taskType.destroy', $selectedType->id) }}">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        class="ml-2 text-gray-500 hover:text-gray-600 p-1 rounded-full"
                        title="削除"
                        onclick="return confirm('カテゴリー「{{$selectedType->title}}」を本当に削除しますか？')"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22m-5-4h-6a2 2 0 00-2 2v0h10v0a2 2 0 00-2-2z" />
                        </svg>
                    </button>
                </form>
                {{-- 編集モーダル --}}
                <div 
                    x-show="isEditOpen" x-transition
                    class="fixed inset-0 z-60 flex items-center justify-center"
                >
                    <div class="absolute inset-0 bg-black bg-opacity-50" x-on:click="isEditOpen = false"></div>
                    <div class="relative bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6 z-70" @click.stop>
                        <h3 class="text-lg font-semibold mb-4">カテゴリー編集</h3>

                        <form method="POST" action="">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="block text-gray-700">タイトル</label>
                                <input type="text" name="title" value="{{ $selectedType->title }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" x-on:click="isEditOpen = false">キャンセル</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            {{-- タスク追加フォーム --}}
            <form 
                method="POST" 
                action="{{ route('task.store', $selectedType->id) }}"
                class="flex mb-4"
            >
                @csrf
                <input name="title" type="text" placeholder="タスクを追加..." class="flex-1 border rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700">追加</button>
            </form>

            {{-- タスク一覧 --}}
            <ul class="space-y-2">
                @foreach($tasks as $index => $task)
                    <div x-data="{ isOpen: false ,isEditOpen: false }">
                        <button 
                            class="flex justify-between items-center py-2 border rounded w-full hover:bg-gray-50"
                            x-on:click="isOpen = true"
                        >
                            <div class="px-4">{{ $task->title }}</div>
                            {{-- ステータスラベル --}}
                            <div class="px-4 text-sm font-semibold">
                                @if($task->status === 'done')
                                    <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">完了</span>
                                @elseif($task->status === 'doing')
                                    <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full">着手中</span>
                                @elseif($task->status === 'todo')
                                    <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full">未着手</span>
                                @endif
                            </div>
                        </button>
                        {{-- モーダル --}}

                        <div 
                            x-show="isOpen"
                            x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center"
                        >

                            {{-- 背景オーバーレイ --}}
                            <div 
                                class="absolute inset-0 bg-black bg-opacity-50"
                                x-on:click="isOpen = false"
                            ></div>

                            {{-- モーダル本体 --}}
                            <div 
                                class="relative bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6 z-10"
                                x-on:click.stop
                            >
                                <div class="flex items-center mb-4">
                                    {{-- タイトル --}}
                                    <h3 class="text-lg font-semibold">{{ $task->title }}</h3>

                                    {{-- 編集ボタン（鉛筆アイコン） --}}
                                    <button 
                                        class="ml-auto text-gray-500 hover:text-gray-700 p-1 rounded-full"
                                        x-on:click="isEditOpen = true"
                                        title="編集"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M16.5 3.5l4 4L12 16l-4 1 1-4 8.5-8.5z" />
                                        </svg>
                                    </button>
                                    {{-- 削除ボタン（ゴミ箱アイコン） --}}
                                    <form method="POST" action="{{ route('task.destroy', $task->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="ml-2 text-gray-500 hover:text-gray-600 p-1 rounded-full"
                                            title="削除"
                                            onclick="return confirm('本当に削除しますか？')"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22m-5-4h-6a2 2 0 00-2 2v0h10v0a2 2 0 00-2-2z" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- 閉じるボタン --}}
                                    <button 
                                        class="ml-2 text-gray-500 hover:text-gray-700 p-1 rounded-full"
                                        x-on:click="isOpen = false"
                                        title="閉じる"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- 説明 --}}
                                @if($task->description)
                                    <p class="text-gray-600 mb-6">
                                        {{ $task->description }}
                                    </p>
                                @endif
                                
                                {{-- 期日 --}}
                                @if($task->due_date)
                                    <p class="text-gray-500 mb-6">
                                        期限: {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}
                                    </p>
                                @endif
                    
                                {{-- ステータスボタン --}}
                                <div class="flex flex-wrap gap-2">
                                    <form method="POST" action="{{ route('task.status', $task->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="done">
                                        <button class="px-3 py-1 bg-blue-400 text-white rounded hover:bg-blue-500">
                                            完了
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('task.status', $task->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="doing">
                                        <button class="px-3 py-1 bg-green-400 text-white rounded hover:bg-green-500">
                                            着手中
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('task.status', $task->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="todo">
                                        <button class="px-3 py-1 bg-red-400 text-white rounded hover:bg-red-500">
                                            未着手
                                        </button>
                                    </form>

                                </div>

                                {{-- 編集モーダル --}}
                                <div 
                                    x-show="isEditOpen" x-transition
                                    class="fixed inset-0 z-60 flex items-center justify-center"
                                >
                                    <div class="absolute inset-0 bg-black bg-opacity-50" x-on:click="isEditOpen = false"></div>
                                    <div class="relative bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6 z-70" @click.stop>
                                        <h3 class="text-lg font-semibold mb-4">タスク編集</h3>

                                        <form method="POST" action="{{ route('task.update', $task->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label class="block text-gray-700">タイトル</label>
                                                <input type="text" name="title" value="{{ $task->title }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-gray-700">説明</label>
                                                <textarea name="description" class="w-full resize-none border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ $task->description }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-gray-700">期限</label>
                                                <input type="date" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </div>

                                            <div class="flex justify-end gap-2 mt-4">
                                                <button type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" x-on:click="isEditOpen = false">キャンセル</button>
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">保存</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </ul>
        </section>
    </div>
</x-app>