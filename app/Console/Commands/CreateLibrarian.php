<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateLibrarian extends Command
{
    /**
     * @var string
     */
    protected $signature = 'librarian:create {email} {password}';

    /**
     * @var string
     */
    protected $description = 'Create a new librarian user';

    /**
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists!');
            return;
        }

        User::create([
            'name' => 'Librarian', 
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'librarian', 
        ]);

        $this->info('Librarian created successfully!');
    }
}
