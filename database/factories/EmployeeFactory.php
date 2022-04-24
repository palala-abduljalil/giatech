<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employeeNumber' => $this->faker->numerify('2022######'),
            'firstName' => $this->faker->firstNameMale,
            'middleName' => $this->faker->firstNameFemale,
            'lastName' => $this->faker->lastName,
            'dateOfBirth' => $this->faker->date('Y-m-d'),
            'yearGraduated' => $this->faker->year,
            'picture' => 'default.png',
            'position_id' => $this->faker->numberBetween(1, 6),
            'department_id' => $this->faker->numberBetween(1, 4),
            'status_id' => $this->faker->numberBetween(1, 3),
            'university_id' => 1,
            'degree_id' => $this->faker->numberBetween(1, 4)
        ];
    }
}
