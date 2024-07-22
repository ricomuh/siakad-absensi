<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassRoom>
 */
class ClassRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => function ($attributes) {
                // return 'Kelas ' . $attributes['grade'] . ' ' . $this->faker->randomLetter;
                return 'Kelas ' . $attributes['grade'] . '' . str($this->faker->randomLetter)->upper();
            },
        ];
    }
}
