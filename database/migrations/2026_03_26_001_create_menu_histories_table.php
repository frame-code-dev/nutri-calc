<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_histories', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 20)->unique();          // 032026001
            $table->unsignedInteger('week_number');
            $table->unsignedInteger('year');
            $table->date('start_date');                      // Senin
            $table->date('end_date');                        // Sabtu
            $table->string('description');                   // Menu dari ... – ...
            $table->foreignId('sppg_id')->nullable()->constrained('master_sppgs')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_histories');
    }
};
