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
        Schema::create('datasets', function (Blueprint $table) {

            $table->id();

            // Nama file Excel
            $table->string('nama_file');

            // Layanan yang terdapat pada dataset
            $table->string('layanan')->nullable();

            // Jumlah baris transaksi
            $table->unsignedInteger('jumlah_data')->default(0);

            // 1 = dataset aktif
            // 0 = dataset arsip
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};