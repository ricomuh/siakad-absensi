<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_subject_id' => 1,
            'day' => $this->faker->numberBetween(0, 6),
            'start_time' => $this->faker->time(),
            // add 1 or 2 hours to start_time
            'end_time' => fn (array $attributes) => Carbon::parse($attributes['start_time'])
                ->addHours($this->faker->randomElement([1, 2]))
                ->format('H:i:s'),
        ];
    }
}
