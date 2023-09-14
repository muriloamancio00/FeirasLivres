<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Product::class;



    public function definition()
    {

        $category_id = $this->faker->randomElement([1,2,3,4,5]);
        return [
            'nome' => $this->faker->word,
            'descricao' => $this->faker->sentence,
            'category_id' => $category_id
        ];
    }
}
