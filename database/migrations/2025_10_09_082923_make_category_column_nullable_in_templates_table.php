<?php

// Ini adalah bagian yang salah sebelumnya, sekarang sudah benar
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
        Schema::table('templates', function (Blueprint $table) {
            // Mengubah kolom 'category' agar boleh null (nullable)
            $table->string('category')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            // Mengembalikan aturan seperti semula jika migrasi di-rollback
            $table->string('category')->nullable(false)->change();
        });
    }
};