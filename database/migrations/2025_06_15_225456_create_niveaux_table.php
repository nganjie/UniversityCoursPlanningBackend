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
        Schema::create('niveaux', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('filliere_id');
            $table->string('code');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('filliere_id')->references('id')->on('fillieres')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveaux');
    }
};
