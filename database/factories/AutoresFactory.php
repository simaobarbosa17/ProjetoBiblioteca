<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autores>
 */
class AutoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $autores = [
            'autor1.png',
            'autor2.png',
            'autor3.png',
            'autor4.png',
        ];
        return [
            'nome' => $this->faker->firstName(),
            'foto' => 'storage/app/public/autor/' . $this->faker->randomElement($autores),
        ];
    }
}
