<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $user = User::create([
//            'username' => 'admin',
//            'nama' => 'admin',
//            'no_hp' => 'admin',
//            'role'    => 'admin',
//            'email'    => 'admin@gmail.com',
//            'password' => Hash::make('admin'),
//        ]);
        $this->call([
            UserSeeder::class,
            provinsiSeeder::class,
            citySeeder::class
        ]);
    }
}
