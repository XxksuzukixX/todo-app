<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_type_id',
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
    ];
    protected $casts = [
        'due_date' => 'datetime',
    ];

    // タスクが属する種類
    public function taskType()
    {
        return $this->belongsTo(TaskType::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'todo'  => '未着手',
            'doing' => '着手中',
            'done'  => '完了',
            default => '不明',
        };
    }
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'todo'  => 'text-red-600',
            'doing' => 'text-green-600',
            'done'  => 'text-blue-600',
            default => 'text-gray-600',
        };
    }
}