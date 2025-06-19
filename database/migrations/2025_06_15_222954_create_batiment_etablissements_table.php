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
        Schema::create('batiment_etablissements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('batiment_id');
            $table->uuid('etablissement_id');
            $table->string('name')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('batiment_id')->references('id')->on('batiments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batiment_etablissements');
    }
};
