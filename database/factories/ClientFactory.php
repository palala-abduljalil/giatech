<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->firstNameMale,
            'middleName' => $this->faker->firstNameFemale,
            'lastName' => $this->faker->lastName,
            'suffix' => $this->faker->suffix,
        ];
    }
}
