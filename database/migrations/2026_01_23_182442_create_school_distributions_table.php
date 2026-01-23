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
        Schema::create('school_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kloter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('distribution_unit_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable(); // e.g. "MTs Ma'arif 1"
            $table->integer('small_portion_count')->default(0);
            $table->integer('large_portion_count')->default(0);
            $table->integer('teacher_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_distributions');
    }
};
