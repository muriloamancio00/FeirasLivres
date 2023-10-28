<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
//    private $typeRoles = [0, 1, 2];
//    private $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $type = $this->typeRoles[$this->index++];

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '11111111', // password
            'remember_token' => Str::random(10),
            'isAdmin' => rand(0,1),
            'isFeirante' => rand(0,1),
            'isSuper' => rand(0,1),
        ];
    }
}
