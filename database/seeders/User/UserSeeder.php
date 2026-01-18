<?php

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'id' => 1, 
                'email' => 'harley@wearedarsh.com',
                'password' => Hash::make('Yelrahmot123!'),
                'first_name' => 'Tom', 
                'last_name' => 'Harley', 
                'is_admin' => true,
                'receives_admin_notifications' => true,
                'role_id' => 4,
                'active' => true
            ],
            [
                'id' => 2, 
                'email' => 'testuser@eventscan.co.uk',
                'password' => Hash::make('password123!'),
                'first_name' => 'Tom', 
                'last_name' => 'Harley', 
                'is_admin' => false,
                'receives_admin_notifications' => false,
                'role_id' => null,
                'active' => true
            ]
        ];

        User::insert($users);
    }
}
