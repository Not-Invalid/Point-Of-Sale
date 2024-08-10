<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => 'jl plp',
            ],
            [
                'username' => 'user',
                'email' => 'user@test.com',
                'password' => Hash::make('12345678'),
                'role' => 'kasir',
                'address' => 'jl plp',
            ],
            
        ]);
    }
}
