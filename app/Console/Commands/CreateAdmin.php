<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter the username:');
        $email = $this->ask('Enter the email:');
        $password = $this->secret('Enter the password (hidden input):');

        // Create the user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);

        $this->info("Admin created successfully.");
    }
}
