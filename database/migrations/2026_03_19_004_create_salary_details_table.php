<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('salary_periods')->cascadeOnDelete();
            $table->foreignId('relawan_id')->constrained('relawans')->cascadeOnDelete();
            // Hari kerja disimpan sebagai JSON: {"senin":100,"selasa":100,...}
            // Nilai 100 = hadir, 0 = tidak hadir. Nilai bisa juga jam kerja.
            $table->json('hari_kerja')->nullable();
            $table->integer('total_hari')->default(0);    // Total hari hadir (count nilai > 0)
            $table->decimal('upah_per_hari', 15, 2)->default(0); // Snapshot / override
            $table->decimal('total_upah', 15, 2)->default(0);    // total_hari * upah + komponen
            $table->timestamps();

            $table->unique(['period_id', 'relawan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};
