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
        Schema::create('transaction_concepts', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable(false);
            $table->text("description")->nullable();
            $table->boolean("active")->default(true);
            $table->string('transaction_type');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('church_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('church_id')->references('id')->on('churches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_concepts');
    }
};
