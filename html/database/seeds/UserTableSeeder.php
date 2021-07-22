<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"      => "Administrador",
            "email"     => "administrador@example.com",
            "password"  => bcrypt("mario.sanchez2021"),
            "role_id"   => 1
        ]);

        User::create([
            "name"      => "Ejecutivo",
            "email"     => "ejecutivo@gmail.com",
            "password"  => bcrypt("marionelo"),
            "role_id"   => 2
        ]);

        for ($i=0; $i < 3; $i++) {
            User::create([
                "name"      => "Producer $i",
                "email"     => "producer$i@example.com",
                "password"  => bcrypt("marionelo"),
                "role_id"   => 3
            ]);
        }
    }
}
