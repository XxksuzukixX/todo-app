<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Facades\Auth;

class TaskTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tasks(Request $request, $type_id)
    {
        $user = Auth::user();
        
        // ユーザーのカテゴリー一覧
        $taskTypes = $user->taskTypes()
            ->withCount([
                'tasks as todo_count' => function ($query) {
                    $query->where('status', 'todo');
                },
                'tasks as doing_count' => function ($query) {
                    $query->where('status', 'doing');
                },
                'tasks as done_count' => function ($query) {
                    $query->where('status', 'done');
                },
            ])
            ->orderBy('title')
            ->get();

        // 選択したカテゴリーのみ取得
        $selectedType = TaskType::where('user_id', $user->id)
            ->where('id', $type_id)
            ->firstOrFail();

        // タスクの取得
        $tasks = $selectedType->tasks()
            ->where('user_id', $user->id)
            ->get();

        return view('pages.tasks', compact('tasks', 'taskTypes', 'selectedType'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // カテゴリーを作成して変数に格納
        $taskType = TaskType::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);
        return redirect()->route('tasks', $taskType->id);
    }

    public function update(Request $request, TaskType $taskType)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $taskType->update([
            'title' => $request->title,
        ]);

        return back(); // 編集後、元のタスク詳細モーダルが閉じる想定
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskType $taskType)
    {
        //
        $taskType->delete();
        return redirect()->route('home')
                        ->with('success', 'タスクを削除しました');
    }
}
