<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('screening_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->nullOnDelete();
            $table->string('session_token', 255)->nullable()->unique();
            $table->enum('status', ['in_progress','completed','emergency_stopped'])
                  ->default('in_progress');
            $table->timestamp('informed_consent_at')->nullable();
            $table->boolean('emergency_triggered')->default(false);
            $table->unsignedTinyInteger('emergency_item')->nullable();
            $table->unsignedSmallInteger('score_total')->nullable();
            $table->unsignedSmallInteger('score_cognitive_affective')->nullable();
            $table->unsignedSmallInteger('score_somatic')->nullable();
            $table->decimal('fuzzy_centroid_value', 5, 2)->nullable();
            $table->enum('depression_level', ['minimal','ringan','sedang','berat'])
                  ->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screening_sessions');
    }
};