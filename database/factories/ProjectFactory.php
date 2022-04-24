<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text($maxNbChars = 200),
            'client_id' => $this->faker->numberBetween(14, 14),
            'status_id' => $this->faker->numberBetween(1, 2),
            'category_id' => $this->faker->numberBetween(1, 3),
            'totalContractPrice' => $this->faker->randomFloat(),
            'startDate' => $this->faker->date,
            'endDate' => $this->faker->date
        ];
    }
}
