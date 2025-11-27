<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'id' => 1, 
                'name' => 'Super admin', 
                'active' => true,
                'key_name' => 'super_admin'
            ],
            [
                'id' => 2, 
                'name' => 'Admin', 
                'active' => true,
                'key_name' => 'admin'

            ],
            [
                'id' => 3, 
                'name' => 'App user', 
                'active' => true,
                'key_name' => 'app_user'
            ]
            ,
            [
                'id' => 4, 
                'name' => 'Developer', 
                'active' => true,
                'key_name' => 'developer'
            ]
        ];

        Role::insert($roles);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
