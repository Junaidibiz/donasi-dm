<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Menambahkan kolom untuk status visibilitas doa
            // Default TRUE artinya semua doa baru akan langsung tampil
            $table->boolean('is_pray_visible')->default(true)->after('pray');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('is_pray_visible');
        });
    }
};