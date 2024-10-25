<?php

namespace App\Http\Controllers;
use Http;
abstract class Controller
{
    $response = Http::get('https://reqres.in/api/users');

    if ($response->successful()) {
        $users = $response->json()['data'];

        foreach ($users as $user) {
            // Assuming you have a User model and a migration set up
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    // Add other fields as necessary
                ]
            );
        }

        $this->info('Users fetched successfully.');
    } else {
        $this->error('Failed to fetch users.');
    }
}
