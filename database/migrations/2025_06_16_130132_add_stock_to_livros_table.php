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
        Schema::table('livros', function (Blueprint $table) {
            $table->unsignedInteger('stock')->default(0)->after('preco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table) {
             $table->dropColumn('stock');
        });
    }
};
