<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function store(Request $request, $task_type_id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'task_type_id' => 'nullable|exists:task_types,id',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'task_type_id' => $task_type_id,
            'title' => $request->title,
            // 'description' => $request->description,
            'status' => 'todo',
            // 'due_date' => $request->due_date,
        ]);
        return redirect()->route('tasks', $task_type_id);
    }
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,doing,done',
        ]);
        $task->update([
            'status' => $request->status
        ]);
        return back(); // ← 今はフォーム送信なのでJSONではなくback
    }
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return back(); // 編集後、元のタスク詳細モーダルが閉じる想定
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */


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
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks', $task->task_type_id)
                        ->with('success', 'タスクを削除しました');
    }
}
