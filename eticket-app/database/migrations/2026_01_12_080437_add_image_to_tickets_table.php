<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // HANYA tambah kolom jika belum ada di database
            if (!Schema::hasColumn('tickets', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // HANYA hapus kolom jika kolomnya memang ada
            if (Schema::hasColumn('tickets', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};