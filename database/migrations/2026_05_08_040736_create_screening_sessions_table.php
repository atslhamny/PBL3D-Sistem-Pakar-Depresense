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
        Schema::create('screening_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('session_token')->nullable(); // For guests
            $table->enum('status', ['in_progress', 'completed', 'emergency_stopped'])->default('in_progress');
            $table->timestamp('informed_consent_at');
            $table->boolean('emergency_triggered')->default(false);
            $table->integer('emergency_item')->nullable();
            $table->integer('score_total')->nullable();
            $table->integer('score_cognitive_affective')->nullable();
            $table->integer('score_somatic')->nullable();
            $table->decimal('fuzzy_centroid_value', 5, 2)->nullable();
            $table->enum('depression_level', ['minimal', 'ringan', 'sedang', 'berat'])->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_sessions');
    }
};
