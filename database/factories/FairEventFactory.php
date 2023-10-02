<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Fair;
use App\Models\FairsEvents;
use Illuminate\Database\Eloquent\Factories\Factory;

class FairEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = FairsEvents::class;

    public function definition()
    {

        $fair_id = $this->faker->randomElement([1,2,3,4,5]);
        $event_id = $this->faker->randomElement([1,2,3,4,5]);
        $status = $this->faker->randomElement([1,2,3,4,5]);
        return [
            'fair_id' => $fair_id,
            'event_id' => $event_id,
            'data' => $this->faker->date,
            'status' => $status,
            'horarioInicio' => $this->faker->time('H:i:s', 'now'),
            'horarioFim' => $this->faker->time('H:i:s', 'now'),
        ];
    }
}
