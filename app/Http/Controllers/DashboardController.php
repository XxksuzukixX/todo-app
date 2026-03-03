<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ユーザーのカテゴリー一覧
        // $taskTypes = $user->taskTypes()->orderBy('title')->get();
        
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

        $statusCounts = [
            'todo'  => $taskTypes->sum('todo_count'),
            'doing' => $taskTypes->sum('doing_count'),
            'done'  => $taskTypes->sum('done_count'),
        ];

        // 選択中のカテゴリーID
        $selectedTypeId = $request->query('type') ?? ($taskTypes->first()->id ?? null);

        // 選択中カテゴリーのタスク一覧
        $tasks = $selectedTypeId
            ? Task::where('task_type_id', $selectedTypeId)->get()
            : collect();
        // 最近追加したタスクを取得（最大3件）
        $recentTasks = Task::whereHas('taskType') // taskType が存在するものだけ
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->take(3)
            ->get();

        // 期日が迫った未着手タスク（最大3件）
        $upcomingTasks = Task::whereHas('taskType')
            ->where('user_id', $user->id)
            ->where('status', 'todo')
            ->whereNotNull('due_date')
            ->orderBy('due_date', 'asc') // 締め切りが近い順
            ->take(3)
            ->get();

        return view('pages.index', 
            compact(
                'taskTypes', 
                'tasks', 
                'selectedTypeId', 
                'statusCounts',
                'recentTasks',
                'upcomingTasks'
            )
        );
    }
}