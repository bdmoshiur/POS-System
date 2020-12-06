<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'usertype' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile' => '01749302454',
            'address' => 'dhaka bangladesh',
            'gender' => 'male',
            'image' => 'logo.jpg',
            'password' => bcrypt('admin@gmail.com')
        ]);
    }
}
