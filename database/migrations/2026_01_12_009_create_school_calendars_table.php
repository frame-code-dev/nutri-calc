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
        Schema::create('school_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('day_status', ['receive', 'holiday'])->comment('Menerima / Libur');
            $table->foreignId('menu_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('portion_count')->default(0)->comment('Number of portions for this day');
            $table->integer('week_number');
            $table->integer('year');
            $table->timestamps();
            
            $table->unique(['school_id', 'date']);
            $table->index(['week_number', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_calendars');
    }
};
