<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Example Example',
            'phone' => '380986662233',
            'email' => 'Delem@gmail.com',
            'password' => bcrypt('33445522'),
            'note' => 'example'
        ]);
    }
}
