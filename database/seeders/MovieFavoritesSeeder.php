<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieFavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = (int)$this->command->ask('How many users do you need ?', 10);

        $this->command->info("Creating {$count} users.");

        // Create the Genre
        $users = \App\Models\User::factory($count)->create();

        $this->command->info('Users Created!');

        $countFavorites = (int)$this->command->ask('How many favorite movies per user do you want ?', 3);

        foreach($users as $user){
            $movieIds = Movie::inRandomOrder()->take($countFavorites)->pluck('id');
            $user->favorites()->attach($movieIds);
            
        }

        $this->command->info('Added favorite movies to each user!');
    }
}
