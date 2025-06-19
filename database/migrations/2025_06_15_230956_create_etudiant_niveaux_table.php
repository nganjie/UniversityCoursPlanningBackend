<?php

use App\Enums\EtudiantStatusEnum;
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
        Schema::create('etudiant_niveaux', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('etudiant_id');
            $table->uuid('niveau_id');
            $table->timestamp('year');
            $table->enum('status',EtudiantStatusEnum::toArray());
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant_niveaux');
    }
};
