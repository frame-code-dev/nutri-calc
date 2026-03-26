<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_history_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_history_id')->constrained('menu_histories')->cascadeOnDelete();
            $table->date('date');
            $table->string('day_name', 20);                  // Senin, Selasa, …
            $table->foreignId('menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->string('photo_path')->nullable();        // Storage path
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('uploaded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_history_days');
    }
};
