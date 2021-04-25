<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'full_name' => 'Example Example',
            'phone' => '380989376117',
            'email' => 'DelemExample@gmail.com',
        ]);
    }
}
