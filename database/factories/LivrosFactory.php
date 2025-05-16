<?php

namespace Database\Factories;

use App\Models\Livros;
use App\Models\Editoras;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livros>
 */
class LivrosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $capas = [
            'livro1.png',
            'livro2.jpg',
            'livro3.jpg',
            'livro4.jpg',
        ];
        return [
            'isbn' => $this->faker->isbn13(),
            'nome' => $this->faker->sentence(1),
            'editora_id' => Editoras::factory(),
            'bibliografia' => $this->faker->paragraphs(1, true),
            'capa' => 'storage/capas/' . $this->faker->randomElement($capas),
            'preco' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}