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
        Schema::create('fuzzy_membership_params', function (Blueprint $table) {
            $table->id();
            $table->string('variable_name');
            $table->enum('linguistic_label', ['minimal', 'ringan', 'sedang', 'berat']);
            $table->enum('function_type', ['trapezoid_left', 'triangle', 'trapezoid_right', 'trapezoid']);
            $table->decimal('param_a', 6, 2);
            $table->decimal('param_b', 6, 2);
            $table->decimal('param_c', 6, 2);
            $table->decimal('param_d', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_membership_params');
    }
};
