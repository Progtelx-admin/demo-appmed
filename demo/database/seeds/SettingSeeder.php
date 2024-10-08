<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        Setting::insert([
            [
                'key' => 'info',
                'value' => json_encode([
                    'name' => 'APPMED DEMO',
                    'currency' => 'USD',
                    'address' => 'Address',
                    'phone' => '+99',
                    'email' => 'support@360lims.com',
                    'website' => 'https://www.360lims.com',
                    'timezone' => 'Europe/London',
                    'language' => 'en',
                    'footer' => 'All rights are reserved',
                    'socials' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'instagram' => '#',
                        'youtube' => '#',
                    ],
                    'preloader' => 'preloader.gif',
                ]),
            ],
            [
                'key' => 'barcode',
                'value' => json_encode([
                    'type' => 'CODE11',
                    'width' => 60,
                    'height' => 150,
                ]),
            ],
            [
                'key' => 'reports',
                'value' => json_encode([
                    'show_header' => true,
                    'show_footer' => true,
                    'show_signature' => true,
                    'show_qrcode' => true,
                    'show_avatar' => true,
                    'margin-top' => '0',
                    'margin-right' => '20',
                    'margin-bottom' => '20',
                    'margin-left' => '20',
                    'content-margin-top' => '280',
                    'content-margin-bottom' => '220',
                    'qrcode-dimension' => 120,
                    'branch_name' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'branch_info' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'patient_title' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'patient_data' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'test_title' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'test_name' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'test_head' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'result' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'unit' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'reference_range' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'status' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'comment' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'signature' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'antibiotic_name' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'sensitivity' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'commercial_name' => [
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                    ],
                    'report_footer' => [
                        'border-width' => 1,
                        'border-color' => 'black',
                        'background-color' => 'white',
                        'color' => '#000000',
                        'font-size' => '12',
                        'font-family' => 'sans-serif',
                        'text-align' => 'center',
                    ],
                    'report_header' => [
                        'border-width' => 1,
                        'border-color' => 'black',
                        'background-color' => 'white',
                        'text-align' => 'center',
                    ],
                ]),
            ],
            [
                'key' => 'emails',
                'value' => json_encode([
                    'host' => '',
                    'port' => '',
                    'username' => '',
                    'password' => '',
                    'encryption' => '',
                    'from_address' => '',
                    'from_name' => '',
                    'header_color' => '#c43e00',
                    'footer_color' => '#363636',
                    'patient_code' => [
                        'active' => false,
                        'subject' => 'Patient Code',
                        'body' => 'Welcome , {patient_name}<br>Your patient code is : {patient_code}',
                    ],
                    'reset_password' => [
                        'active' => false,
                        'subject' => 'Reset your password',
                        'body' => 'Reset your password',
                    ],
                    'receipt' => [
                        'active' => false,
                        'subject' => 'Order receipt',
                        'body' => 'Welcome {patient_name},<br> your receipt is attached',
                    ],
                    'report' => [
                        'active' => false,
                        'subject' => 'Medical report',
                        'body' => 'welcome , {patient_name}<br>you report is attached',
                    ],
                ]),
            ],
            [
                'key' => 'sms',
                'value' => json_encode([
                    'gateway' => 'nexmo',
                    'twilio' => [
                        'sid' => '',
                        'token' => '',
                        'from' => '',
                    ],
                    'nexmo' => [
                        'key' => '',
                        'secret' => '',
                    ],
                    'textLocal' => [
                        'key' => '',
                        'sender' => '',
                    ],
                    'infobip' => [
                        'base_url' => '',
                        'from' => '',
                        'key' => '',
                    ],
                    'patient_code' => [
                        'active' => false,
                        'message' => 'welcome {patient_name} , your patient code is {patient_code}',
                    ],
                    'tests_notification' => [
                        'active' => false,
                        'message' => 'welcome {patient_name} , your tests are ready now .. you can check tests by using your patient code : {patient_code}',
                    ],
                ]),
            ],
            [
                'key' => 'whatsapp',
                'value' => json_encode([
                    'receipt' => [
                        'active' => false,
                        'message' => 'welcome {patient_name} , receipt link is {receipt_link}',
                    ],
                    'report' => [
                        'active' => false,
                        'message' => 'welcome {patient_name} , tests report link is {report_link}',
                    ],
                ]),
            ],
            [
                'key' => 'api_keys',
                'value' => json_encode([
                    'google_map' => '',
                ]),
            ],
        ]);
    }
}
