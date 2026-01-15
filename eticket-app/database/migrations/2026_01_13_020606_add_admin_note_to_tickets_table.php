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
        Schema::table('tickets', function (Blueprint $table) {
            // Menambahkan kolom admin_note setelah kolom status
            // nullable() artinya kolom ini boleh kosong (tidak wajib diisi)
            $table->text('admin_note')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('admin_note');
        });
    }
};