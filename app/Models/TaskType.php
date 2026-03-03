<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
    ];

    // タスク種類に紐づくユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // タスク種類に紐づくタスク
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}