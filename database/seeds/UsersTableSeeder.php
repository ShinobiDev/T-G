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

        $user = new User;
        $user->name = "Edgar Guzman";
        $user->email = "stalindesarrollador@gmail.com";
        $user->password = bcrypt('123');
        $user->rol_id = 2;
        $user->save();

        $user = new User;
        $user->name = "Camilo Monrroy";
        $user->email = "stalinchacu@outlook.com";
        $user->password = bcrypt('123');
        $user->rol_id = 2;
        $user->save();

        $user = new User;
        $user->name = "Angelica Loaiza";
        $user->email = "josepolytropo@gmail.com";
        $user->password = bcrypt('123');
        $user->rol_id = 3;
        $user->save();

        $user = new User;
        $user->name = "Paola Cardona";
        $user->email = "stalin@mohansoft.com";
        $user->password = bcrypt('123');
        $user->rol_id = 3;
        $user->save();

    }
}
