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
        Schema::create('sous_niveaux', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('niveau_id');
            $table->string('code');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_niveaux');
    }
};
