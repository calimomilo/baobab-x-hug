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
        Schema::create('collect_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collect_id')->constrained('collects')->onDelete('cascade');
            $table->string('session_id');
            $table->enum('data_type', ['donor_result', 'appointment_clic', 'donor_share', 'supporter_result', 'supporter_share']);
            $table->timestamps();

            $table->unique(['session_id', 'data_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_data');
    }
};
