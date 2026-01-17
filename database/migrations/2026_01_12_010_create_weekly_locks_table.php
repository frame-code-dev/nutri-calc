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
        Schema::create('weekly_locks', function (Blueprint $table) {
            $table->id();
            $table->integer('week_number');
            $table->integer('year');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->enum('status', ['draft', 'pending', 'locked'])->default('draft');
            $table->boolean('is_locked')->default(false);
            $table->foreignId('locked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('locked_at')->nullable();
            $table->foreignId('unlocked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamps();
            
            $table->unique(['week_number', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_locks');
    }
};
