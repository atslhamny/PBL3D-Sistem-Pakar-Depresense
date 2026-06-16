<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jadikan kolom antecedent_total nullable karena arsitektur fuzzy
     * diubah dari 3 input variabel (Total, Kognitif, Somatik) menjadi
     * 2 input variabel (Kognitif, Somatik).
     * Kolom ini dipertahankan (tidak dihapus) untuk backward compatibility.
     */
    public function up(): void
    {
        Schema::table('fuzzy_rules', function (Blueprint $table) {
            $table->enum('antecedent_total', ['minimal', 'ringan', 'sedang', 'berat'])
                  ->nullable()
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('fuzzy_rules', function (Blueprint $table) {
            $table->enum('antecedent_total', ['minimal', 'ringan', 'sedang', 'berat'])
                  ->nullable(false)
                  ->change();
        });
    }
};
