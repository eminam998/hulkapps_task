<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


       return
            ['title' => $this->faker->sentence(5),
            'description' => $this->faker->realText(rand(80, 600)),
            'release_date'  => $this->faker->date(),
            'rating' => rand(1,5),
            'photo'  => 'https://via.placeholder.com/350x150',
            'slug'   => str_replace('--', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', trim($this->faker->sentence(5))))),
        ];

    }
}
