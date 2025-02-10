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
        Schema::create('churches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id')->default(170);
            $table->unsignedBigInteger('Province_id');
            $table->unsignedBigInteger('corregimiento_id');
            $table->string('pastor_name'); 
            $table->string('email')->nullable();
            $table->string('phone'); 
            $table->string('street_address');
            $table->boolean('active')->default(true);
            $table->timestamps();

            // Agregar claves foráneas
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('corregimiento_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};
