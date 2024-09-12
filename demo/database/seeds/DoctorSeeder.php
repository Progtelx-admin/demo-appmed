<?php

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Doctor::truncate(); 
        
        Doctor::create([
            'code' => 'DOC001',
            'name' => 'Dr. John Doe',
            'phone' => '123-456-7890',
            'email' => 'john@example.com',
            'address' => '123 Main St',
            'commission' => 10.5,
            'doctor_code' => 'DC001',
        ]);

        Doctor::create([
            'code' => 'DOC002',
            'name' => 'Dr. Samantha Lee',
            'phone' => '456-789-0123',
            'email' => 'samantha@example.com',
            'address' => '456 Elm St',
            'commission' => 12.75,
            'doctor_code' => 'DC002',
        ]);

        Doctor::create([
            'code' => 'DOC003',
            'name' => 'Dr. Michael Chang',
            'phone' => '789-012-3456',
            'email' => 'michael@example.com',
            'address' => '789 Oak St',
            'commission' => 15.25,
            'doctor_code' => 'DC003',
        ]);

        Doctor::create([
            'code' => 'DOC004',
            'name' => 'Dr. Emily Smith',
            'phone' => '012-345-6789',
            'email' => 'emily@example.com',
            'address' => '012 Pine St',
            'commission' => 14.0,
            'doctor_code' => 'DC004',
        ]);

        Doctor::create([
            'code' => 'DOC005',
            'name' => 'Dr. Alexander Rodriguez',
            'phone' => '234-567-8901',
            'email' => 'alexander@example.com',
            'address' => '234 Cedar St',
            'commission' => 16.5,
            'doctor_code' => 'DC005',
        ]);
    }
}
