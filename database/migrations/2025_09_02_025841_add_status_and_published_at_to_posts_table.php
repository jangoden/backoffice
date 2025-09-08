<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // tambah 'status' jika belum ada
            if (! Schema::hasColumn('posts', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft');
            }

            // hanya tambah 'published_at' jika belum ada (punyamu sudah ada)
            if (! Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'status')) {
                $table->dropColumn('status');
            }
            // sengaja tidak menjatuhkan 'published_at' karena sudah ada sebelumnya
        });
    }
};
