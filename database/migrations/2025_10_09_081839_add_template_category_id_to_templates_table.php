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
        Schema::table('templates', function (Blueprint $table) {
            $table->foreignId('template_category_id')
                  ->nullable()
                  ->after('id') // Meletakkan kolom ini setelah kolom 'id'
                  ->constrained('template_categories') // Menghubungkan ke tabel baru kita
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['template_category_id']);
            $table->dropColumn('template_category_id');
        });
    }
};