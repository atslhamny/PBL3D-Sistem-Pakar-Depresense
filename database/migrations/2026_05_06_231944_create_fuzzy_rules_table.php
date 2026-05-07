<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fuzzy_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedSmallInteger('rule_number')->unique();
            $table->enum('antecedent_total',
                         ['minimal','ringan','sedang','berat']);
            $table->enum('antecedent_cognitive',
                         ['minimal','ringan','sedang','berat']);
            $table->enum('antecedent_somatic',
                         ['minimal','ringan','sedang','berat']);
            $table->enum('consequent',
                         ['minimal','ringan','sedang','berat']);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuzzy_rules');
    }
};