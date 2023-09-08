<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // How many genres you need, defaulting to 10
        $count = (int)$this->command->ask('How many genres do you need ?', 10);

        $this->command->info("Creating {$count} genres.");

        // Create the Genre
        $genres = \App\Models\Genre::factory($count)->create();

        $this->command->info('Genres Created!');

        $countMovie = (int)$this->command->ask('How many movies do you need ?', 10);

        $this->command->info("Creating {$countMovie} movies.");

        $movies = \App\Models\Movie::factory($countMovie)->create();

        $countGenres = (int)$this->command->ask('How many genres per movie do you want ?', 2);

        foreach($movies as $movie){
            $genreIds = Genre::inRandomOrder()->take($countGenres)->pluck('id');
            $movie->genres()->attach($genreIds);
            
        }

        $this->command->info('Movies Created!');

    }
}
