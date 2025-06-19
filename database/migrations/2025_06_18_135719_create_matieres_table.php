<?php

use App\Enums\MatiereTypeEnum;
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
        Schema::create('matieres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('niveau_id');
            $table->uuid('sous_niveau_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->enum('type',MatiereTypeEnum::toArray());
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sous_niveau_id')->references('id')->on('sous_niveaux')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
