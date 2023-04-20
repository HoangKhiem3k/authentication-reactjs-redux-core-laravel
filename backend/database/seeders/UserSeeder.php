<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::create([
        //     'id' => 99,
        //     'first_name' => "Le",
        //     'last_name' => "Khiem",
        //     'address' => "Da Nang City",
        //     'phone_number' => "0123456789",
        //     'email' => "admin@gmail.com",
        //     'password' => Hash::make("123456"),
        // ]);
        $users = [
            [   
                'id' => 1,
                'first_name' => 'Administrator',
                'last_name' => 'Khiem',
                'email' => 'admin@gmail.com',
                'address' => "Da Nang City",
                'phone_number' => "0123456789",
                'password' => Hash::make("123456"),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'first_name' => 'DAC',
                'last_name' => 'Member',
                'email' => 'dac@gmail.com',
                'address' => "Da Nang City",
                'phone_number' => "0123456789",
                'password' => Hash::make("123456"),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'first_name' => 'Advertiser',
                'last_name' => '1',
                'email' => 'advertiser@gmail.com',
                'address' => "Da Nang City",
                'phone_number' => "0123456789",
                'password' => Hash::make("123456"),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
