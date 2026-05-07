<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('session_id');
            $table->foreign('session_id')
                  ->references('id')->on('screening_sessions')
                  ->cascadeOnDelete();
            $table->uuid('question_id');
            $table->foreign('question_id')
                  ->references('id')->on('bdi_questions');
            $table->unsignedTinyInteger('answer_value');
            $table->boolean('is_flagged')->default(false);
            $table->timestamp('answered_at')->useCurrent();

            $table->unique(['session_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_answers');
    }
};