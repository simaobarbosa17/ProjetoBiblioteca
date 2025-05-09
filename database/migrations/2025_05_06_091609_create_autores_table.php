<?php

use App\Models\Autores;
use App\Models\Livros;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('foto');
            $table->timestamps();
        });
        Schema::create('livros_autores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Livros::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Autores::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autores');
        Schema::dropIfExists('livros_autores');
    }
};
