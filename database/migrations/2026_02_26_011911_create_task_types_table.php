<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_types', function (Blueprint $table) {
            $table->id()->comment('タスク種類ID');

            $table->foreignId('user_id')
                  ->comment('ユーザーID')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('title')
                  ->comment('種類名');

            $table->timestamps(); // created_at: 作成日時 / updated_at: 更新日時
            $table->softDeletes(); // deleted_at: 削除日時
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_types');
    }
};
