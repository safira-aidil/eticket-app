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
        Schema::table('tickets', function (Blueprint $blueprint) {
            // Kita menggunakan nullable agar data lama yang sudah ada tidak error
            // Column diletakkan setelah kolom 'description' (opsional)
            $blueprint->timestamp('created_at')->nullable()->after('description');
            $blueprint->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['created_at', 'updated_at']);
        });
    }
};