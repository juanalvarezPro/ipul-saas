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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2)->nullable(false);
            $table->unsignedBigInteger('concept_id'); 
            $table->date('transaction_date')->nullable(false);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('workspace_id');
            $table->string('attachments')->nullable();
            $table->timestamps();
    
            // Relaciones
            $table->foreign('concept_id')->references('id')->on('transaction_concepts')->onDelete('cascade');
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
