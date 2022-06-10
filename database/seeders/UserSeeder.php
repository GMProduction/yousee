<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        User::insert([
            [
                'nama' => 'admin',
                'role' => 'admin',
                'no_hp' => '121212',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('admin'),
            ],
            [
                'nama' => 'pimpinan',
                'role' => 'pimpinan',
                'no_hp' => '121212',
                'email' => 'pimpinan@gmail.com',
                'username' => 'pimpinan',
                'password' => Hash::make('pimpinan'),
            ]
        ]);
    }
}
