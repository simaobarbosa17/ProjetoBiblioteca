<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Editoras>
 */
class EditorasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $logos = [
            'logo1.png',
            'logo2.png',
            'logo3.png',
            'logo4.png',
        ];
        return [
            'nome' => $this->faker->company(),
            'logótipo' => 'storage/app/public/logo/' . $this->faker->randomElement($logos),
        ];
    }
}
