<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('isbn');
            $table->string('nome');
            $table->unsignedBigInteger('editora_id'); // Aqui deve ser a chave estrangeira para 'editoras'
            $table->text('bibliografia');
            $table->string('capa');
            $table->decimal('preco', 8, 2);
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('editora_id')->references('id')->on('editoras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
