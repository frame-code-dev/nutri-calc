<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppg_id')->nullable()->constrained('master_sppgs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('model_type')->nullable(); // Fully qualified class name
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('action'); // created, updated, deleted
            $table->string('description')->nullable();
            $table->json('changes')->nullable(); // To store old and new values 
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
