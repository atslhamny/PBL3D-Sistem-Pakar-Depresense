<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->text('description');
            $table->enum('content_type', ['artikel','video','musik','podcast','lainnya']);
            $table->string('url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->enum('target_level',
                         ['minimal','ringan','sedang','berat','semua']);
            $table->unsignedTinyInteger('priority')->default(1);
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->foreign('created_by')
                  ->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};