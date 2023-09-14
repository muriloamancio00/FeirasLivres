<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DayWeekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->randomElement([
                'Segunda-feira',
                'Terca-feira',
                'Quarta-feira',
                'Quinta-feira',
                'Sexta-feira',
                'Sabado',
                'Domingo'
            ])
        ];
    }
}
