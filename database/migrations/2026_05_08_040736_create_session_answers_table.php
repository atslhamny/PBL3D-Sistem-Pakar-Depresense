<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('screening_sessions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('bdi_questions')->cascadeOnDelete();
            $table->tinyInteger('answer_value'); // 0, 1, 2
            $table->timestamp('answered_at')->useCurrent();
            
            $table->unique(['session_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_answers');
    }
};
