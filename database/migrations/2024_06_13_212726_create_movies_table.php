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
            Schema::create('movies', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->string('director')->nullable();
                $table->integer('duracion');
                $table->text('sinopsis');
                $table->date('fecha_estreno');
                $table->string('genero');
                $table->string('clasificacion');
                $table->string('portada')->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //
        });
    }
};
