<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_id')->constrained('salary_details')->cascadeOnDelete();
            $table->string('nama'); // e.g. "Dana Kesehatan", "Bonus", "Tunjangan Transport"
            $table->decimal('jumlah', 15, 2)->default(0); // bisa positif (tunjangan) atau negatif (potongan)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_components');
    }
};
