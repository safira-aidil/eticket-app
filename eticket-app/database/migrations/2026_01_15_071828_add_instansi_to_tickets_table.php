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
            // Menambahkan kolom instansi setelah kolom user_id agar rapi
            // nullable() digunakan agar data lama tidak error saat kolom ini ditambah
            $table->string('instansi')->after('user_id')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('instansi');
        });
    }
};