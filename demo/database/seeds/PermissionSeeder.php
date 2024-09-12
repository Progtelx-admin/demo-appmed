<?php

use App\Models\Appointment;
use App\Models\Laboratory;
use App\Models\Module;
use App\Models\Pathology;
use App\Models\Permission;
use App\Models\Instrument;
use App\Models\HealthCertificateTest;
use App\Models\PointOfSale;
use App\Models\CashInOutflow;
use App\Models\Service;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        Module::truncate();

        //dashboard
        $dashboard_module = Module::Create([
            'name' => 'Dashboard',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_general_statistics',
                    'name' => 'View general statistics',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_income_statistics',
                    'name' => 'View income statistics',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_tests_statistics',
                    'name' => 'View tests statistics',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_best_income_packages',
                    'name' => 'View best income packages',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_best_income_tests',
                    'name' => 'View best income tests',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_best_income_cultures',
                    'name' => 'View best income cultures',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_online_admins',
                    'name' => 'View online admins',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_online_patients',
                    'name' => 'View online patients',
                ],
                [
                    'module_id' => $dashboard_module['id'],
                    'key' => 'view_today_visits',
                    'name' => 'View today home visits',
                ],

            ]
        );

        //categories
        $categories_module = Module::Create([
            'name' => 'categories',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $categories_module['id'],
                    'key' => 'view_category',
                    'name' => 'View',
                ],
                [
                    'module_id' => $categories_module['id'],
                    'key' => 'create_category',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $categories_module['id'],
                    'key' => 'edit_category',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $categories_module['id'],
                    'key' => 'delete_category',
                    'name' => 'Delete',
                ],
            ]
        );

        //tests
        $tests_module = Module::Create([
            'name' => 'tests',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $tests_module['id'],
                    'key' => 'view_test',
                    'name' => 'View',
                ],
                [
                    'module_id' => $tests_module['id'],
                    'key' => 'create_test',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $tests_module['id'],
                    'key' => 'edit_test',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $tests_module['id'],
                    'key' => 'delete_test',
                    'name' => 'Delete',
                ],
                [
                    'module_id' => $tests_module['id'],
                    'key' => 'view_test_orders',
                    'name' => 'View order',
                ],
            ]
        );

        //cultures
        $cultures_module = Module::Create([
            'name' => 'cultures',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $cultures_module['id'],
                    'key' => 'view_culture',
                    'name' => 'View',
                ],
                [
                    'module_id' => $cultures_module['id'],
                    'key' => 'create_culture',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $cultures_module['id'],
                    'key' => 'edit_culture',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $cultures_module['id'],
                    'key' => 'delete_culture',
                    'name' => 'Delete',
                ],
            ]
        );

        //packages
        $packages_module = Module::Create([
            'name' => 'packages',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $packages_module['id'],
                    'key' => 'view_package',
                    'name' => 'View',
                ],
                [
                    'module_id' => $packages_module['id'],
                    'key' => 'create_package',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $packages_module['id'],
                    'key' => 'edit_package',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $packages_module['id'],
                    'key' => 'delete_package',
                    'name' => 'Delete',
                ],
            ]
        );

        //antibiotics
        $antibiotics_module = Module::Create([
            'name' => 'antibiotics',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $antibiotics_module['id'],
                    'key' => 'view_antibiotic',
                    'name' => 'View',
                ],
                [
                    'module_id' => $antibiotics_module['id'],
                    'key' => 'create_antibiotic',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $antibiotics_module['id'],
                    'key' => 'edit_antibiotic',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $antibiotics_module['id'],
                    'key' => 'delete_antibiotic',
                    'name' => 'Delete',
                ],
            ]
        );

        //culture options
        $culture_options_module = Module::Create([
            'name' => 'culture options',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $culture_options_module['id'],
                    'key' => 'view_culture_option',
                    'name' => 'View',
                ],
                [
                    'module_id' => $culture_options_module['id'],
                    'key' => 'create_culture_option',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $culture_options_module['id'],
                    'key' => 'edit_culture_option',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $culture_options_module['id'],
                    'key' => 'delete_culture_option',
                    'name' => 'Delete',
                ],
            ]
        );

        //doctors
        $doctors_module = Module::Create([
            'name' => 'doctors',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $doctors_module['id'],
                    'key' => 'view_doctor',
                    'name' => 'View',
                ],
                [
                    'module_id' => $doctors_module['id'],
                    'key' => 'create_doctor',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $doctors_module['id'],
                    'key' => 'edit_doctor',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $doctors_module['id'],
                    'key' => 'delete_doctor',
                    'name' => 'Delete',
                ],
            ]
        );

        //groups
        $groups_module = Module::Create([
            'name' => 'groups tests',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $groups_module['id'],
                    'key' => 'view_group',
                    'name' => 'View',
                ],
                [
                    'module_id' => $groups_module['id'],
                    'key' => 'create_group',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $groups_module['id'],
                    'key' => 'edit_group',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $groups_module['id'],
                    'key' => 'delete_group',
                    'name' => 'Delete',
                ],
            ]
        );

        //patients
        $patients_module = Module::Create([
            'name' => 'patients',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $patients_module['id'],
                    'key' => 'view_patient',
                    'name' => 'View',
                ],
                [
                    'module_id' => $patients_module['id'],
                    'key' => 'create_patient',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $patients_module['id'],
                    'key' => 'edit_patient',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $patients_module['id'],
                    'key' => 'delete_patient',
                    'name' => 'Delete',
                ],
            ]
        );

        //Medical reports
        $medical_reports_module = Module::Create([
            'name' => 'Medical reports',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'view_medical_report',
                    'name' => 'View',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'create_medical_report',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'edit_medical_report',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'delete_medical_report',
                    'name' => 'Delete',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'sign_medical_report',
                    'name' => 'Sign',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'sign_medical_report2',
                    'name' => 'Sign2',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'sign_medical_report3',
                    'name' => 'Sign3',
                ],
                [
                    'module_id' => $medical_reports_module['id'],
                    'key' => 'sign_medical_report4',
                    'name' => 'Sign4',
                ],
            ]
        );

        //Reports
        $reports_module = Module::Create([
            'name' => 'Reports',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_accounting_report',
                    'name' => 'View accounting report',
                ],
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_doctor_report',
                    'name' => 'View doctor report',
                ],
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_supplier_report',
                    'name' => 'View supplier report',
                ],
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_purchase_report',
                    'name' => 'View purchase report',
                ],
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_inventory_report',
                    'name' => 'View inventory report',
                ],
                [
                    'module_id' => $reports_module['id'],
                    'key' => 'view_product_report',
                    'name' => 'View product report',
                ],
            ]
        );

        //roles
        $roles_module = Module::Create([
            'name' => 'roles',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $roles_module['id'],
                    'key' => 'view_role',
                    'name' => 'View',
                ],
                [
                    'module_id' => $roles_module['id'],
                    'key' => 'create_role',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $roles_module['id'],
                    'key' => 'edit_role',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $roles_module['id'],
                    'key' => 'delete_role',
                    'name' => 'Delete',
                ],
            ]
        );

        //users
        $users_module = Module::Create([
            'name' => 'users',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $users_module['id'],
                    'key' => 'view_user',
                    'name' => 'View',
                ],
                [
                    'module_id' => $users_module['id'],
                    'key' => 'create_user',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $users_module['id'],
                    'key' => 'edit_user',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $users_module['id'],
                    'key' => 'delete_user',
                    'name' => 'Delete',
                ],
            ]
        );

        //price list
        $price_list_module = Module::Create([
            'name' => 'price list',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'view_test_prices',
                    'name' => 'View tests prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'update_test_prices',
                    'name' => 'update tests prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'view_culture_prices',
                    'name' => 'View cultures prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'update_culture_prices',
                    'name' => 'Update cultures prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'view_package_prices',
                    'name' => 'View packages prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'update_package_prices',
                    'name' => 'Update packages prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'view_service_prices',
                    'name' => 'View Service prices',
                ],
                [
                    'module_id' => $price_list_module['id'],
                    'key' => 'update_service_prices',
                    'name' => 'Update service prices',
                ],
            ]
        );

        //accounting
        $accounting_module = Module::Create([
            'name' => 'accounting reports',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $accounting_module['id'],
                    'key' => 'view_accounting_reports',
                    'name' => 'View',
                ],
                [
                    'module_id' => $accounting_module['id'],
                    'key' => 'generate_report_accounting',
                    'name' => 'Generate',
                ],
            ]
        );

        //payment methods
        $payment_methods_module = Module::Create([
            'name' => 'payment methods',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $payment_methods_module['id'],
                    'key' => 'view_payment_method',
                    'name' => 'View',
                ],
                [
                    'module_id' => $payment_methods_module['id'],
                    'key' => 'create_payment_method',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $payment_methods_module['id'],
                    'key' => 'edit_payment_method',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $payment_methods_module['id'],
                    'key' => 'delete_payment_method',
                    'name' => 'Delete',
                ],
            ]
        );

        //visits
        $visits_module = Module::Create([
            'name' => 'Home visits',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'view_visit',
                    'name' => 'View',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'create_visit',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'edit_visit',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'delete_visit',
                    'name' => 'Delete',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'view_visitDr',
                    'name' => 'View Dr',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'view_visitDr',
                    'name' => 'View Dr 2',
                ],
            ]
        );

        //visits
        $visits_module = Module::Create([
            'name' => 'Clinic visits',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'view_visitc',
                    'name' => 'View',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'create_visitc',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'edit_visitc',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $visits_module['id'],
                    'key' => 'delete_visitc',
                    'name' => 'Delete',
                ],
            ]
        );

        //branches
        $branches_module = Module::Create([
            'name' => 'Branches',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $branches_module['id'],
                    'key' => 'view_branch',
                    'name' => 'View',
                ],
                [
                    'module_id' => $branches_module['id'],
                    'key' => 'create_branch',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $branches_module['id'],
                    'key' => 'edit_branch',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $branches_module['id'],
                    'key' => 'delete_branch',
                    'name' => 'Delete',
                ],
            ]
        );

        //contracts
        $contracts_module = Module::Create([
            'name' => 'contracts',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $contracts_module['id'],
                    'key' => 'view_contract',
                    'name' => 'View',
                ],
                [
                    'module_id' => $contracts_module['id'],
                    'key' => 'create_contract',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $contracts_module['id'],
                    'key' => 'edit_contract',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $contracts_module['id'],
                    'key' => 'delete_contract',
                    'name' => 'Delete',
                ],
            ]
        );

        //expense category
        $expense_category_module = Module::Create([
            'name' => 'expense categories',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $expense_category_module['id'],
                    'key' => 'view_expense_category',
                    'name' => 'View',
                ],
                [
                    'module_id' => $expense_category_module['id'],
                    'key' => 'create_expense_category',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $expense_category_module['id'],
                    'key' => 'edit_expense_category',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $expense_category_module['id'],
                    'key' => 'delete_expense_category',
                    'name' => 'Delete',
                ],
            ]
        );

        //expenses
        $expense_module = Module::Create([
            'name' => 'Expenses',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $expense_module['id'],
                    'key' => 'view_expense',
                    'name' => 'View',
                ],
                [
                    'module_id' => $expense_module['id'],
                    'key' => 'create_expense',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $expense_module['id'],
                    'key' => 'edit_expense',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $expense_module['id'],
                    'key' => 'delete_expense',
                    'name' => 'Delete',
                ],
            ]
        );

        //backups
        $backups_module = Module::Create([
            'name' => 'Backups',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $backups_module['id'],
                    'key' => 'view_backup',
                    'name' => 'View',
                ],
                [
                    'module_id' => $backups_module['id'],
                    'key' => 'create_backup',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $backups_module['id'],
                    'key' => 'delete_backup',
                    'name' => 'Delete',
                ],
            ]
        );

        //settings
        $setting_module = Module::Create([
            'name' => 'setting',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $setting_module['id'],
                    'key' => 'view_setting',
                    'name' => 'Update',
                ],
            ]
        );

        //chat
        $chat_module = Module::Create([
            'name' => 'Chat',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $chat_module['id'],
                    'key' => 'view_chat',
                    'name' => 'View',
                ],
            ]
        );

        //activity log
        $log_module = Module::Create([
            'name' => 'Actvity logs',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $log_module['id'],
                    'key' => 'view_activity_log',
                    'name' => 'View',
                ],
                [
                    'module_id' => $log_module['id'],
                    'key' => 'clear_activity_log',
                    'name' => 'Clear',
                ],
            ]
        );

        //translation
        $translation_module = Module::Create([
            'name' => 'Translation',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $translation_module['id'],
                    'key' => 'view_translation',
                    'name' => 'View',
                ],
                [
                    'module_id' => $translation_module['id'],
                    'key' => 'edit_translation',
                    'name' => 'Edit',
                ],
            ]
        );

        //suppliers
        $supplier_module = Module::Create([
            'name' => 'Suppliers',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $supplier_module['id'],
                    'key' => 'view_supplier',
                    'name' => 'View',
                ],
                [
                    'module_id' => $supplier_module['id'],
                    'key' => 'create_supplier',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $supplier_module['id'],
                    'key' => 'edit_supplier',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $supplier_module['id'],
                    'key' => 'delete_supplier',
                    'name' => 'Delete',
                ],
            ]
        );

        //products
        $product_module = Module::Create([
            'name' => 'Products',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $product_module['id'],
                    'key' => 'view_product',
                    'name' => 'View',
                ],
                [
                    'module_id' => $product_module['id'],
                    'key' => 'create_product',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $product_module['id'],
                    'key' => 'edit_product',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $product_module['id'],
                    'key' => 'delete_product',
                    'name' => 'Delete',
                ],
            ]
        );

        //purchases
        $purchase_module = Module::Create([
            'name' => 'Purchases',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $purchase_module['id'],
                    'key' => 'view_purchase',
                    'name' => 'View',
                ],
                [
                    'module_id' => $purchase_module['id'],
                    'key' => 'create_purchase',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $purchase_module['id'],
                    'key' => 'edit_purchase',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $purchase_module['id'],
                    'key' => 'delete_purchase',
                    'name' => 'Delete',
                ],
            ]
        );

        //adjustments
        $adjustment_module = Module::Create([
            'name' => 'Adjustments',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $adjustment_module['id'],
                    'key' => 'view_adjustment',
                    'name' => 'View',
                ],
                [
                    'module_id' => $adjustment_module['id'],
                    'key' => 'create_adjustment',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $adjustment_module['id'],
                    'key' => 'edit_adjustment',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $adjustment_module['id'],
                    'key' => 'delete_adjustment',
                    'name' => 'Delete',
                ],
            ]
        );

        //transfers
        $transfer_module = Module::Create([
            'name' => 'Transfers',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $transfer_module['id'],
                    'key' => 'view_transfer',
                    'name' => 'View',
                ],
                [
                    'module_id' => $transfer_module['id'],
                    'key' => 'create_transfer',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $transfer_module['id'],
                    'key' => 'edit_transfer',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $transfer_module['id'],
                    'key' => 'delete_transfer',
                    'name' => 'Delete',
                ],
            ]
        );
        //instruments
        $instruments_module = Instrument::Create([
            'name' => 'instruments',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $instruments_module['id'],
                    'key' => 'view_instrument',
                    'name' => 'View',
                ],
                [
                    'module_id' => $instruments_module['id'],
                    'key' => 'create_instrument',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $instruments_module['id'],
                    'key' => 'edit_instrument',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $instruments_module['id'],
                    'key' => 'delete_instrument',
                    'name' => 'Delete',
                ],
            ]
        );

        //Pos Transaction
        $postrans_module = Module::Create([
            'name' => 'Pos Transactions',
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'view_cash_in',
                    'name' => 'View Cash in',
                ],
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'change_pos_nav',
                    'name' => 'Change',
                ],
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'delete_pos_transactions',
                    'name' => 'Delete',
                ],
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'edit_pos_transactions',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'create_pos_transactions',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $postrans_module['id'],
                    'key' => 'view_pos_transactions',
                    'name' => 'View POS',
                ],
            ]
        );

        //POS
        $pos_module = Module::Create([
            'name' => 'Point of Sales'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $pos_module['id'],
                    'key' => 'delete_pos',
                    'name' => 'Delete',
                ],
                [
                    'module_id' => $pos_module['id'],
                    'key' => 'edit_pos',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $pos_module['id'],
                    'key' => 'create_pos',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $pos_module['id'],
                    'key' => 'view_pos',
                    'name' => 'View',
                ],
            ]
        );

        //permission
        $permission_module = Module::Create([
            'name' => 'Permissions'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $permission_module['id'],
                    'key' => 'create_permission',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $permission_module['id'],
                    'key' => 'view_permission',
                    'name' => 'View',
                ],
                [
                    'module_id' => $permission_module['id'],
                    'key' => 'edit_permission',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $permission_module['id'],
                    'key' => 'delete_permission',
                    'name' => 'Delete',
                ],
            ]
        );

        //appointments
        $appointments_module = Module::Create([
            'name' => 'Appointments'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $appointments_module['id'],
                    'key' => 'view_appointments_all',
                    'name' => 'View',
                ],
                [
                    'module_id' => $appointments_module['id'],
                    'key' => 'view_appointments_branch',
                    'name' => 'View Branch',
                ],
                [
                    'module_id' => $appointments_module['id'],
                    'key' => 'create_appointments',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $appointments_module['id'],
                    'key' => 'edit_appointments',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $appointments_module['id'],
                    'key' => 'delete_appointments',
                    'name' => 'Delete',
                ],
            ]
        );

        //healthcertificates
        $healthcertificates_module = Module::Create([
            'name' => 'Healthcertificates'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $healthcertificates_module['id'],
                    'key' => 'view_healthcertificates',
                    'name' => 'View',
                ],
                [
                    'module_id' => $healthcertificates_module['id'],
                    'key' => 'create_healthcertificates',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $healthcertificates_module['id'],
                    'key' => 'edit_healthcertificates',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $healthcertificates_module['id'],
                    'key' => 'delete_healthcertificates',
                    'name' => 'Delete',
                ],
            ]
        );

        //laboratories
        $laboratories_module = Module::Create([
            'name' => 'Laboratory'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $laboratories_module['id'],
                    'key' => 'view_laboratory',
                    'name' => 'View',
                ],
                [
                    'module_id' => $laboratories_module['id'],
                    'key' => 'create_laboratory',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $laboratories_module['id'],
                    'key' => 'edit_laboratory',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $laboratories_module['id'],
                    'key' => 'delete_laboratory',
                    'name' => 'Delete',
                ],
            ]
        );

        //pathologies
        $pathologies_module = Module::Create([
            'name' => 'Pathology'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $pathologies_module['id'],
                    'key' => 'view_pathologys',
                    'name' => 'View',
                ],
                [
                    'module_id' => $pathologies_module['id'],
                    'key' => 'create_pathologys',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $pathologies_module['id'],
                    'key' => 'edit_pathologys',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $pathologies_module['id'],
                    'key' => 'delete_pathologys',
                    'name' => 'Delete',
                ],
            ]
        );

        //services
        $services_module = Module::Create([
            'name' => 'Services'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $services_module['id'],
                    'key' => 'view_service',
                    'name' => 'View',
                ],
                [
                    'module_id' => $services_module['id'],
                    'key' => 'create_service',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $services_module['id'],
                    'key' => 'edit_service',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $services_module['id'],
                    'key' => 'delete_service',
                    'name' => 'Delete',
                ],
            ]
        );

        //vats
        $vats_module = Module::Create([
            'name' => 'Vats'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $vats_module['id'],
                    'key' => 'view_vat',
                    'name' => 'View',
                ],
                [
                    'module_id' => $vats_module['id'],
                    'key' => 'create_vat',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $vats_module['id'],
                    'key' => 'edit_vat',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $vats_module['id'],
                    'key' => 'delete_vat',
                    'name' => 'Delete',
                ],
            ]
        );

        //visit dr
        $visitsdr_module = Module::Create([
            'name' => 'Visit Doctors'
        ]);

        Permission::insert(
            [
                [
                    'module_id' => $visitsdr_module['id'],
                    'key' => 'view_visitdr',
                    'name' => 'View',
                ],
                [
                    'module_id' => $visitsdr_module['id'],
                    'key' => 'create_visitdr',
                    'name' => 'Create',
                ],
                [
                    'module_id' => $visitsdr_module['id'],
                    'key' => 'edit_visitdr',
                    'name' => 'Edit',
                ],
                [
                    'module_id' => $visitsdr_module['id'],
                    'key' => 'delete_visitdr',
                    'name' => 'Delete',
                ],
            ]
        );
    }
}
