<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom expires_at dan update enum status untuk:
     * - Session timeout: sesi in_progress kadaluarsa setelah 30 menit
     * - Status 'expired' untuk sesi yang habis waktu
     */
    public function up(): void
    {
        Schema::table('screening_sessions', function (Blueprint $table) {
            // Waktu kadaluarsa sesi (null = tidak ada batas, untuk data lama)
            $table->timestamp('expires_at')->nullable()->after('informed_consent_at');
        });

        // Update enum: tambah 'expired' ke kolom status
        // SQLite tidak mendukung ALTER COLUMN, jadi gunakan raw SQL kondisional
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            Schema::getConnection()->statement(
                "ALTER TABLE screening_sessions MODIFY COLUMN status
                 ENUM('in_progress', 'completed', 'emergency_stopped', 'expired')
                 NOT NULL DEFAULT 'in_progress'"
            );
        }
        // SQLite & PostgreSQL: enum direpresentasikan sebagai string,
        // tidak perlu ALTER — constraint dihandle di application layer (Enum PHP)
    }

    public function down(): void
    {
        Schema::table('screening_sessions', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            Schema::getConnection()->statement(
                "ALTER TABLE screening_sessions MODIFY COLUMN status
                 ENUM('in_progress', 'completed', 'emergency_stopped')
                 NOT NULL DEFAULT 'in_progress'"
            );
        }
    }
};
