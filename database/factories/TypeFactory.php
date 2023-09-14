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

    private $nameRoles = ['Feirante', 'Administrador'];
    private $index = 0;

    public function definition()
    {
        $name = $this->nameRoles[$this->index++];

        return [
            'nome' => $name,
        ];
    }
}
