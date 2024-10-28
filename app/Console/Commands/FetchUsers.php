<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Userapi;

class FetchUsers extends Command
{
    protected $signature = 'fetch:users';
    protected $description = 'Fetch users from the API and update the database';

    public function handle()
    {
        // Step 1: Fetch data from the external API
        $response = Http::get('https://reqres.in/api/users');

        if ($response->successful()) {
            // Step 2: Retrieve users data from the response
            $users = $response->json()['data'];

            // Step 3: Loop through each user and update the database
            foreach ($users as $user) {
                Userapi::updateOrCreate(
                    ['email' => $user['email']], // Search condition for existing user
                    [
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'avatar' => $user['avatar'],
                    ]
                );
            }

            $this->info('Users fetched and stored successfully.');
        } else {
            $this->error('Failed to fetch users from the API.');
        }
    }
}
