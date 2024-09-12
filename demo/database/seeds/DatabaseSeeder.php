<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesSeeder::class,
            AntibioticsSeeder::class,
            TimezoneSeeder::class,
            BranchSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            ServicesSeeder::class,
            CurrencySeeder::class,
            MicrobiologyTestsSeeder::class,
            PackagesSeeder::class,
            SettingSeeder::class,
            CategoriesSeeder::class,
            TestsSeeder::class,
            CulturesSeeder::class,
            CultureOptionsSeeder::class,
            PatientSeeder::class,
            LanguageSeeder::class,
            PointOfSaleSeeder::class,
        ]);

        \DB::table('activity_log')->truncate();
    }
}
