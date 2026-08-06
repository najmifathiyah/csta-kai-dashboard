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
    Schema::create('researchs', function (Blueprint $table) {

        $table->id();

        $table->string('kode_research')->unique();

        $table->string('judul');

        $table->foreignId('division_id')
              ->constrained('divisions')
              ->cascadeOnDelete();

        $table->foreignId('category_id')
              ->constrained('categories')
              ->cascadeOnDelete();

        $table->string('penanggung_jawab');

        $table->year('tahun');

        $table->date('tanggal_penelitian');

        $table->enum('status', [
            'Draft',
            'Proses',
            'Selesai'
        ]);

        $table->text('ringkasan')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
