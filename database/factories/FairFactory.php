<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'endereco' => $this->faker->address,
            'horarioInicio' => $this->faker->time('H:i:s'),
            'horarioFim' => $this->faker->time('H:i:s'),
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
        ];
    }
}
