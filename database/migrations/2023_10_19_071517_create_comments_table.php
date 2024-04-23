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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('article_id')->constrained()->cascadeOnDelete(); // "cascadeOnDelete" = Si jamais on supprime 'un article', ça supprimera automatiquement 'ses commentaires'.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // "constrained" = La contrainte de la clef étrangère !
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
