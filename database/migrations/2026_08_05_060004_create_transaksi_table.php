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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id();

        $table->date('periode');

        $table->string('layanan');

        $table->string('tipe_layanan');

        $table->string('channel');

        $table->integer('transaksi');

        $table->integer('jumlah_pelanggan');

        $table->decimal('nilai_transaksi', 18, 2);

        $table->decimal('fee_kai', 18, 2);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
