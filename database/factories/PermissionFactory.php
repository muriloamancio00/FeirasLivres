<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        $arr_cat = [ 'bancas', 'eventos', 'feiras',  'produtos','categorias', ];
        $arr_pag = ['index', 'create', 'edit', 'show'];

        $regra = $this->faker->randomElement($arr_cat) . '.' . $this->faker->randomElement($arr_pag);
        $permissao = $this->faker->boolean;
        $type_id = $this->faker->randomElement([1, 2]);

        return [
            'regra' => $regra,
            'permissao' => $permissao,
            'type_id' => $type_id,
        ];
    }
}
