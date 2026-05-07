<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bdi_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedTinyInteger('item_number')->unique();
            $table->text('question_text');
            $table->enum('category', ['kognitif_afektif', 'somatik']);
            $table->enum('sub_category', ['Emosi', 'Kognitif', 'Fisik']);
            $table->boolean('is_safety_item')->default(false);
            $table->unsignedTinyInteger('safety_threshold')->nullable();
            $table->integer('sort_order');
            $table->boolean('is_locked')->default(false);
            $table->integer('version')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bdi_questions');
    }
};