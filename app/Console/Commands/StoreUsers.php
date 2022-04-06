<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class StoreUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StoreUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores Users from the API into a database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start_page = 1;
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET','https://reqres.in/api/users');

        $data = json_decode($res->getBody()->getContents(), true);

        $total_pages = $data['total_pages'];

        for($i = $start_page; $i <= $total_pages; $i++){

            $res = $client->request('GET','https://reqres.in/api/users?page='.$i);
            $data = json_decode($res->getBody()->getContents(), true);

            $users = $data['data'];

            $this->saveUsers($users);

        }

        $this->line('Users Saved');
    }

    public function saveUsers($users){
        foreach ($users as $user){
            //dd($user);
            User::firstOrCreate([
                'name' => $user['first_name'].' '.$user['last_name'],
                'email' => $user['email'],
                'password' => '',
            ])->save();
        }
    }
}
