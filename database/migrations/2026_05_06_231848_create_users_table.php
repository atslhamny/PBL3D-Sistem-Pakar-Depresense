<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->string('full_name', 255)->nullable();
            $table->string('university', 255)->nullable();
            $table->string('study_program', 255)->nullable();
            $table->integer('semester')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};