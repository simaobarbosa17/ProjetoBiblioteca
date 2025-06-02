<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\requesicoes;
class ReqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        requesicoes::create([
            'user_id' => 2,
            'livros_id' => 3,
            'data_requisicao' => now()->subDays(2),
            'data_entrega' => now()->addDays(1),
        ]);

       



    }
}
