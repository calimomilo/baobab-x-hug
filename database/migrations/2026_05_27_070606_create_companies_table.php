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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('address');
            $table->string('contact_address')->nullable();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('slug')->unique();
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('logo_url');
            $table->string('anonymous')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
