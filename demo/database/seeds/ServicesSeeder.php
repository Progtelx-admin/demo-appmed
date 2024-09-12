<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        Service::truncate();

        $servicesData = [
            [
                'name' => 'Advanced Health Assessment',
                'shortcut' => 'AHA',
                'commercial_name' => 'Complete Health Checkup',
                'price' => 150.00,
                'category_id' => 1,
                'pantheon_id' => 'AHA-001',
            ],
            [
                'name' => 'Revitalizing Therapy',
                'shortcut' => 'RT',
                'commercial_name' => 'Rejuvenation Package',
                'price' => 200.00,
                'category_id' => 2,
                'pantheon_id' => 'RT-002',
            ],
            [
                'name' => 'Diagnostic Profiling',
                'shortcut' => 'DP',
                'commercial_name' => 'Comprehensive Diagnosis',
                'price' => 175.00,
                'category_id' => 3,
                'pantheon_id' => 'DP-003',
            ],
            [
                'name' => 'Lifestyle Optimization',
                'shortcut' => 'LO',
                'commercial_name' => 'Holistic Wellness Program',
                'price' => 180.00,
                'category_id' => 1,
                'pantheon_id' => 'LO-004',
            ],
            [
                'name' => 'Vitality Enhancement',
                'shortcut' => 'VE',
                'commercial_name' => 'Energy Boost Package',
                'price' => 160.00,
                'category_id' => 2,
                'pantheon_id' => 'VE-005',
            ],
            [
                'name' => 'Youthful Glow Therapy',
                'shortcut' => 'YGT',
                'commercial_name' => 'Anti-Aging Treatment',
                'price' => 220.00,
                'category_id' => 3,
                'pantheon_id' => 'YGT-006',
            ],
            [
                'name' => 'Immunity Boosting',
                'shortcut' => 'IB',
                'commercial_name' => 'Immunization Package',
                'price' => 190.00,
                'category_id' => 1,
                'pantheon_id' => 'IB-007',
            ],
            [
                'name' => 'Mental Wellness Evaluation',
                'shortcut' => 'MWE',
                'commercial_name' => 'Psychological Assessment',
                'price' => 170.00,
                'category_id' => 2,
                'pantheon_id' => 'MWE-008',
            ],
            [
                'name' => 'Nutritional Analysis',
                'shortcut' => 'NA',
                'commercial_name' => 'Dietary Health Check',
                'price' => 195.00,
                'category_id' => 3,
                'pantheon_id' => 'NA-009',
            ],
            [
                'name' => 'Fitness Regimen Consultation',
                'shortcut' => 'FRC',
                'commercial_name' => 'Exercise Program Planning',
                'price' => 180.00,
                'category_id' => 1,
                'pantheon_id' => 'FRC-010',
            ],
        ];

        foreach ($servicesData as $serviceData) {
            Service::create($serviceData);
        }
    }
}
