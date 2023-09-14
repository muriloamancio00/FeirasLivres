<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Type::class;

    public function definition()
    {
        $name_role = ['Administrador','Feirante'];
        $name = $this->faker->unique()->randomElement($name_role);

        return [
            'nome' => $name,
        ];
    }
}
