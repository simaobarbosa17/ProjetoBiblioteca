<?php

namespace Database\Seeders;

use App\Models\carrinho;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrinhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        carrinho::create([
            'user_id' => 2,
            'livros_id' => 1,
            'created_at' => Carbon::now()->subHours(2),
            'updated_at' => Carbon::now()->subHours(2),
            'alerta_enviado' => false,
        ]);
    }
}
