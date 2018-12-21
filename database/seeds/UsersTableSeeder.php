<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::truncate();

        $user = new User;
        $user->name = "Stalin Chacon";
        $user->email = "stalin1@misena.edu.co";
        $user->password = bcrypt('123');
        $user->rol_id = 1;
        $user->save();

    }
}
