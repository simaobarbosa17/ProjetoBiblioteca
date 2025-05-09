<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livros;
use App\Models\Autores;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Livros::factory()
            ->count(30)
            ->create()
            ->each(function ($livro) {
                $autores = Autores::factory()->count(rand(1, 2))->create();
                $livro->autores()->attach($autores);
            });

    }
}