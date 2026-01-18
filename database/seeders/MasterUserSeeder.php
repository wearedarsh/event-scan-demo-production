<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterUserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\User\RoleSeeder::class,
            \Database\Seeders\User\UserSeeder::class,
        ]);
    }
}
