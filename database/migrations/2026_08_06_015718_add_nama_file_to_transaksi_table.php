<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NAMA_FILE SUDAH ADA
        |--------------------------------------------------------------------------
        |
        | Kolom nama_file sudah tersedia di tabel transaksi.
        |
        | Migration ini sebelumnya dibuat untuk menambahkan kolom tersebut,
        | tetapi karena kolomnya sudah ada, kita tidak perlu menjalankan
        | ALTER TABLE lagi.
        |
        | Migration tetap dibiarkan agar Laravel mencatatnya sebagai
        | migration yang sudah dijalankan.
        |
        */
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA YANG DIHAPUS
        |--------------------------------------------------------------------------
        |
        | Jangan menghapus nama_file karena kolom ini sedang digunakan
        | oleh sistem dataset.
        |
        */
    }
};