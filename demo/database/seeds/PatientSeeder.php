<?php

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::truncate();

        Patient::create([
            'code' => '1593914720',
            'name' => 'patient',
            'gender' => 'male',
            'dob' => '1995-08-28',
            'phone' => '00',
            'email' => 'patient@360lims.com',
            'address' => 'USA',
        ]);

        Patient::create([
            'code' => '1593914720',
            'name' => 'John Doe',
            'gender' => 'male',
            'dob' => '1980-04-15',
            'phone' => '123-456-7890',
            'email' => 'john.doe@example.com',
            'address' => '123 Main Street, Anytown, USA',
        ]);

        Patient::create([
            'code' => '1593914721',
            'name' => 'Jane Smith',
            'gender' => 'female',
            'dob' => '1992-09-22',
            'phone' => '987-654-3210',
            'email' => 'jane.smith@example.com',
            'address' => '456 Oak Avenue, Somewhere, Canada',
        ]);

        Patient::create([
            'code' => '1593914722',
            'name' => 'Michael Johnson',
            'gender' => 'male',
            'dob' => '1975-12-10',
            'phone' => '555-123-4567',
            'email' => 'michael.j@example.com',
            'address' => '789 Elm Street, Anytown, UK',
        ]);

        Patient::create([
            'code' => '1593914723',
            'name' => 'Emily White',
            'gender' => 'female',
            'dob' => '1988-06-25',
            'phone' => '444-555-6666',
            'email' => 'emily.white@example.com',
            'address' => '321 Maple Avenue, Somewhere, Australia',
        ]);
    }
}
