<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $divisionId = Division::query()->inRandomOrder();

        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'position' => $this->faker->jobTitle(),
            'division_id' => $this->faker->randomElement($divisionId->pluck('id')),
            'image' => $this->faker->imageUrl(640, 480, 'people'),
        ];
    }
}
