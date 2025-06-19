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
        Schema::create('avis_enseignants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('enseignant_matiere_id');
            $table->uuid('matiere_id');
            $table->string('title');
            $table->longText('description');
            $table->boolean('is_valid')->default(false);
            $table->timestamps();
            $table->foreign('enseignant_matiere_id')->references('id')->on('enseignant_matieres')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_enseignants');
    }
};
