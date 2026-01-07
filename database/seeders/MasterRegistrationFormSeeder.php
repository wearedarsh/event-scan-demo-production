<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterRegistrationFormSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RegistrationForm\RegistrationFormsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormPaidStepsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormPaidInputsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormApprovalStepsSeeder::class,
            \Database\Seeders\RegistrationForm\RegistrationFormApprovalInputsSeeder::class,
        ]);
    }
}
