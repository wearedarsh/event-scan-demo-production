<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterRegistrationFormSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RegistrationForm\RegistrationFormsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormStepsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormInputsSeeder::class,
        ]);
    }
}
