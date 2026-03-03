<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id()->comment('タスクID');

            $table->foreignId('task_type_id')
                  ->comment('タスク種類ID')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('title')
                  ->comment('タスクタイトル');

            $table->text('description')
                  ->nullable()
                  ->comment('タスク説明');

            $table->enum('status', ['todo', 'doing', 'done'])
                  ->default('todo')
                  ->comment('ステータス');

            $table->date('due_date')
                  ->nullable()
                  ->comment('期限日');

            $table->timestamps();   // created_at: 作成日時 / updated_at: 更新日時
            $table->softDeletes();  // deleted_at: 削除日時
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};