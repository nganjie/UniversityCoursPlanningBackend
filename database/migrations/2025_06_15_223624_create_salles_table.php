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
        Schema::create('salles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('batiment_id');
            $table->string('name');
            $table->string('short_name');
            $table->integer('max_capacity');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('batiment_id')->references('id')->on('batiments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};
