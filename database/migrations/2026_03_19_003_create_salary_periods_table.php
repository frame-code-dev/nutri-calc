<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppg_id')->nullable()->constrained('master_sppgs')->nullOnDelete();
            $table->string('nama_periode');
            $table->enum('tipe', ['mingguan', 'bulanan'])->default('mingguan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('periode_ke')->default(1); // Periode I, II, III...
            $table->string('penandatangan_1')->nullable(); // Mengetahui
            $table->string('penandatangan_2')->nullable(); // Menyetujui
            $table->string('instansi')->nullable();         // Nama instansi di slip
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_periods');
    }
};
