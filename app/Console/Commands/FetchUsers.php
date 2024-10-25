<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Make API request (replace with your API endpoint)
            $response = Http::get('https://reqres.in/api/users');
            
            if ($response->successful()) {
                $users = $response->json();
                // Process your users data here
                
                $this->info('Users fetched successfully!');
            } else {
                $this->error('Failed to fetch users from API');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
