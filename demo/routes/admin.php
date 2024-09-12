<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

//login admin
Route::prefix('admin/auth')->middleware('AdminGuest')->name('admin.auth.')->group(function () {
    Route::get('/login', [Auth\AdminController::class, 'login'])->name('login');
    Route::post('/login', [Auth\AdminController::class, 'login_submit'])->name('login_submit');
});
//logout admin
Route::post('admin/logout', [Auth\AdminController::class, 'logout'])->name('admin.logout')->middleware('Admin');

//reset admin users password
Route::prefix('admin/reset')->name('admin.reset.')->group(function () {
    Route::get('/mail', [Auth\AdminController::class, 'mail'])->name('mail');
    Route::post('/mail_submit', [Auth\AdminController::class, 'mail_submit'])->name('mail_submit');
    Route::get('/reset_password_form/{token}', [Auth\AdminController::class, 'reset_password_form'])->name('reset_password_form');
    Route::post('/reset_password_submit', [Auth\AdminController::class, 'reset_password_submit'])->name('reset_password_submit');
});

//admin controls
Route::prefix('admin')->name('admin.')->middleware('Admin', 'Branch')->group(function () {
    //dashboard
    Route::get('/', [Admin\IndexController::class, 'index'])->name('index');

    //change branch
    Route::get('change_branch/{lang}', [Admin\IndexController::class, 'change_branch'])->name('change_branch');

    //change branch POS
    Route::post('update_point_of_sale', [Admin\IndexController::class, 'update_point_of_sale'])->name('update_point_of_sale');


    //profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('edit', [Admin\ProfileController::class, 'edit'])->name('edit');
        Route::post('update', [Admin\ProfileController::class, 'update'])->name('update');
    });

    //categories
    Route::resource('categories', Admin\CategoriesController::class);

    //tests and its components
    Route::resource('tests', Admin\TestsController::class);
    Route::get('get_tests', [Admin\TestsController::class, 'ajax'])->name('get_tests'); //datatable
    Route::get('tests/consumptions/{id}', [Admin\TestsController::class, 'consumptions'])->name('tests.consumptions'); //consumptions
    Route::post('tests/consumptions', [Admin\TestsController::class, 'consumptions_submit'])->name('tests.consumptions.submit'); //consumptions
    Route::get('tests_export', [Admin\TestsController::class, 'export'])->name('tests.export');
    Route::get('tests_download_template', [Admin\TestsController::class, 'download_template'])->name('tests.download_template');
    Route::post('tests_import', [Admin\TestsController::class, 'import'])->name('tests.import');
    Route::post('tests/bulk/delete', [Admin\TestsController::class, 'bulk_delete'])->name('tests.bulk_delete');


        //Microbiology Tests and its components
    Route::resource('microbiology_tests', Admin\MicrobiologyTestController::class);
    Route::get('get_microbiology_tests', [Admin\MicrobiologyTestController::class, 'ajax'])->name('get_microbiology_tests'); //datatable
    Route::get('microbiology_tests/consumptions/{id}', [Admin\MicrobiologyTestController::class, 'consumptions'])->name('microbiology_tests.consumptions'); //consumptions
    Route::post('microbiology_tests/consumptions', [Admin\MicrobiologyTestController::class, 'consumptions_submit'])->name('microbiology_tests.consumptions.submit'); //consumptions

    //tests Orders
    Route::get('tests_orders', [Admin\TestsController::class, 'testOrder'])->name('tests.tests_orders');
    Route::post('category_orders', [Admin\TestsController::class, 'reorderCategory'])->name('tests.tests_category');
    Route::post('tests_reorder', [Admin\TestsController::class, 'reorder'])->name('tests.reorder');
    //cultures Orders
    Route::get('cultures_orders', [Admin\CulturesController::class, 'testOrder'])->name('cultures.cultures_orders');
    Route::post('category_orders_culture', [Admin\CulturesController::class, 'reorderCategory'])->name('cultures.cultures_category');
    Route::post('cultures_reorder', [Admin\CulturesController::class, 'reorder'])->name('cultures.reorder');

    //cultures
    Route::resource('cultures', Admin\CulturesController::class);
    Route::get('get_cultures', [Admin\CulturesController::class, 'ajax'])->name('get_cultures'); //datatable
    Route::get('cultures_export', [Admin\CulturesController::class, 'export'])->name('cultures.export');
    Route::get('cultures_download_template', [Admin\CulturesController::class, 'download_template'])->name('cultures.download_template');
    Route::post('cultures_import', [Admin\CulturesController::class, 'import'])->name('cultures.import');
    Route::post('cultures/bulk/delete', [Admin\CulturesController::class, 'bulk_delete'])->name('cultures.bulk_delete');

    //packages
    Route::resource('packages', Admin\PackagesController::class);
    Route::post('packages/bulk/delete', [Admin\PackagesController::class, 'bulk_delete'])->name('packages.bulk_delete');

    //culture options
    Route::resource('culture_options', Admin\CultureOptionsController::class);
    Route::get('get_culture_options', [Admin\CultureOptionsController::class, 'ajax'])->name('culture_options.ajax');
    Route::post('culture_options/bulk/delete', [Admin\CultureOptionsController::class, 'bulk_delete'])->name('culture_options.bulk_delete');

    //antibiotics
    Route::resource('antibiotics', Admin\AntibioticsController::class);
    Route::get('get_antibiotics', [Admin\AntibioticsController::class, 'ajax'])->name('get_antibiotics'); //datatable
    Route::get('antibiotics_export', [Admin\AntibioticsController::class, 'export'])->name('antibiotics.export');
    Route::get('antibiotics_download_template', [Admin\AntibioticsController::class, 'download_template'])->name('antibiotics.download_template');
    Route::post('antibiotics_import', [Admin\AntibioticsController::class, 'import'])->name('antibiotics.import');
    Route::post('antibiotics/bulk/delete', [Admin\AntibioticsController::class, 'bulk_delete'])->name('antibiotics.bulk_delete');

    //patients
    Route::resource('patients', Admin\PatientsController::class);
    Route::get('get_patients', [Admin\PatientsController::class, 'ajax'])->name('get_patients');
    Route::get('patients_export', [Admin\PatientsController::class, 'export'])->name('patients.export');
    Route::get('patients_download_template', [Admin\PatientsController::class, 'download_template'])->name('patients.download_template');
    Route::post('patients_import', [Admin\PatientsController::class, 'import'])->name('patients.import');
    Route::post('patients/bulk/delete', [Admin\PatientsController::class, 'bulk_delete'])->name('patients.bulk_delete');
    //Api artikujt
    Route::get('groups/apipantheon/{id}', [Admin\GroupsController::class, 'apipantheon'])->name('groups.apipantheon');
    Route::put('groups/updateAPI/{id}', [Admin\GroupsController::class, 'updateapi'])->name('groups.updateapi');

    //groups
    Route::resource('groups', Admin\GroupsController::class);
    Route::post('groups/send_receipt_mail/{id}', [Admin\GroupsController::class, 'send_receipt_mail'])->name('groups.send_receipt_mail');
    Route::post('groups/delete_analysis/{id}', [Admin\GroupsController::class, 'delete_analysis']);
    Route::get('get_groups', [Admin\GroupsController::class, 'ajax'])->name('get_groups');
    Route::post('groups/print_barcode/{group_id}', [Admin\GroupsController::class, 'print_barcode'])->name('groups.print_barcode');
    Route::get('groups/working_paper/{group_id}', [Admin\GroupsController::class, 'working_paper'])->name('groups.working_paper');
    Route::post('groups/bulk/delete', [Admin\GroupsController::class, 'bulk_delete'])->name('groups.bulk_delete');
    Route::post('groups/bulk/print_barcode', [Admin\GroupsController::class, 'bulk_print_barcode'])->name('groups.bulk_print_barcode');
    Route::post('groups/bulk/print_receipt', [Admin\GroupsController::class, 'bulk_print_receipt'])->name('groups.bulk_print_receipt');
    Route::post('groups/bulk/print_working_paper', [Admin\GroupsController::class, 'bulk_print_working_paper'])->name('groups.bulk_print_working_paper');
    Route::post('groups/bulk/send_receipt_mail', [Admin\GroupsController::class, 'bulk_send_receipt_mail'])->name('groups.bulk_send_receipt_mail');
    Route::get('groups_export', [Admin\GroupsController::class, 'export'])->name('results.export');
    Route::get('working_paper_pdf/{id}', [Admin\GroupsController::class, 'working_paper_pdf'])->name('groups.working_paper_pdf');
    Route::get('print_80mm/{id}', [Admin\GroupsController::class, 'print_80mm'])->name('groups.print_80mm');

    Route::get('groups/{id}/order-tests', [Admin\GroupsController::class, 'orderTests'])->name('groups.order-tests');
    Route::post('groups/{id}/update-test-order', [Admin\GroupsController::class, 'updateTestOrder'])->name('groups.updateTestOrder');

    //Medical reports
    Route::resource('medical_reports', Admin\MedicalReportsController::class);
    Route::post('medical_reports/upload_report/{id}', [Admin\MedicalReportsController::class, 'upload_report'])->name('medical_reports.upload_report');
    Route::post('medical_reports/pdf/{id}', [Admin\MedicalReportsController::class, 'pdf'])->name('medical_reports.pdf');
    Route::post('medical_reports/pdf2/{id}', [Admin\MedicalReportsController::class, 'pdf2'])->name('medical_reports.pdf2');
    Route::post('medical_reports/pdf3/{id}', [Admin\MedicalReportsController::class, 'pdf3'])->name('medical_reports.pdf3');
    Route::post('medical_reports/pdf4/{id}', [Admin\MedicalReportsController::class, 'pdf4'])->name('medical_reports.pdf4');
    Route::post('medical_reports/update_culture/{id}', [Admin\MedicalReportsController::class, 'update_culture'])->name('medical_reports.update_culture'); //update cultures
    Route::get('sign_medical_report/{id}', [Admin\MedicalReportsController::class, 'sign'])->name('medical_reports.sign');
    Route::get('confirm_report_medical_report/{id}', [Admin\MedicalReportsController::class, 'confirm_report'])->name('medical_reports.confirm_report');
    Route::get('called_patient_medical_report/{id}', [Admin\MedicalReportsController::class, 'called_patient'])->name('medical_reports.called_patient');
    Route::get('sign_medical_report2/{id}', [Admin\MedicalReportsController::class, 'sign2'])->name('medical_reports.sign2');
    Route::get('sign_medical_report3/{id}', [Admin\MedicalReportsController::class, 'sign3'])->name('medical_reports.sign3');
    Route::get('sign_medical_report4/{id}', [Admin\MedicalReportsController::class, 'sign4'])->name('medical_reports.sign4');
    Route::get('medical_reports/print_report/{id}', [Admin\MedicalReportsController::class, 'print_report'])->name('medical_reports.print_report');
    Route::get('medical_reports/print_report5/{id}', [Admin\MedicalReportsController::class, 'print_report5'])->name('medical_reports.print_report5');
    Route::get('medical_reports/print_reportgr/{id}', [Admin\MedicalReportsController::class, 'print_reportgr'])->name('medical_reports.print_reportgr');
    Route::get('medical_reports/print_reportgr2/{id}', [Admin\MedicalReportsController::class, 'print_reportgr2'])->name('medical_reports.print_reportgr2');
    Route::post('medical_reports/send_report_mail/{id}', [Admin\MedicalReportsController::class, 'send_report_mail'])->name('medical_reports.send_report_mail');
    Route::post('medical_reports/bulk/delete', [Admin\MedicalReportsController::class, 'bulk_delete'])->name('groups.bulk_delete');
    Route::post('medical_reports/bulk/print_barcode', [Admin\MedicalReportsController::class, 'bulk_print_barcode'])->name('groups.bulk_print_barcode');
    Route::post('medical_reports/bulk/sign_report', [Admin\MedicalReportsController::class, 'bulk_sign_report'])->name('groups.bulk_sign_report');
    Route::post('medical_reports/bulk/print_report', [Admin\MedicalReportsController::class, 'bulk_print_report'])->name('groups.bulk_print_report');
    Route::post('medical_reports/bulk/print_report5', [Admin\MedicalReportsController::class, 'bulk_print_report'])->name('groups.bulk_print_report');
    Route::post('medical_reports/bulk/send_report_mail', [Admin\MedicalReportsController::class, 'bulk_send_report_mail'])->name('groups.bulk_send_report_mail');
    Route::put('medical_reports/microbiology_tests_update/{id}', [Admin\MedicalReportsController::class, 'microbiology_tests_update'])->name('medical_reports.microbiology_tests_update');
    // NEW
    Route::put('medical_reports/microbiology_tests_update/{id}', [Admin\MedicalReportsController::class, 'microbiology_tests_update'])->name('medical_reports.microbiology_tests_update');

    //PDF
    Route::get('test-pdf/{id}', [Admin\MedicalReportsController::class, 'testPDF'])->name('medical_reports.test-pdf');
    Route::get('test-pdf2/{id}', [Admin\MedicalReportsController::class, 'testPDF2'])->name('medical_reports.test-pdf2');
    Route::get('culture-pdf/{id}', [Admin\MedicalReportsController::class, 'culturePDF'])->name('medical_reports.culture-pdf');
    Route::get('culture-pdf2/{id}', [Admin\MedicalReportsController::class, 'culturePDF2'])->name('medical_reports.culture-pdf2');
    Route::get('trombofili-pdf/{id}', [Admin\MedicalReportsController::class, 'trombofiliPDF'])->name('medical_reports.trombofili-pdf');
    Route::get('blood-pdf/{id}', [Admin\MedicalReportsController::class, 'bloodPDF'])->name('medical_reports.blood-pdf');
    Route::get('pcr-pdf/{id}', [Admin\MedicalReportsController::class, 'pcrPDF'])->name('medical_reports.pcr-pdf');

    //Show New
    Route::put('/medical_reports/update_show/{id}', [Admin\MedicalReportsController::class, 'updateTestShow'])->name('medical_reports.update_show');
    Route::put('/medical_reports/update_showc/{id}', [Admin\MedicalReportsController::class, 'updateCultureShow'])->name('medical_reports.update_showc');
    Route::get('show2/{id}', [Admin\MedicalReportsController::class, 'show2'])->name('medical_reports.show2');

    //Medical reports
    Route::resource('ikshp_reports', Admin\IkshpReportsController::class);

    //Microbiology reports
    Route::resource('microbiologys', Admin\MicrobiologyController::class);
    Route::get('editMicrobiologys/{id}', [Admin\MedicalReportsController::class, 'editMicrobiology'])->name('medical_reports.edit_microbiology');
    Route::post('microbiologys/upload_report/{id}', [Admin\MicrobiologyController::class, 'upload_report'])->name('microbiologys.upload_report');
    Route::get('called_patient_microbiologys/{id}', [Admin\MicrobiologyController::class, 'called_patient'])->name('microbiologys.called_patient');
    Route::get('microbiologys_medical_report/{id}', [Admin\MicrobiologyController::class, 'confirm_report'])->name('microbiologys.confirm_report');

    //Biochemistry reports
    Route::resource('biochemistrys', Admin\BiochemistryController::class);
    Route::get('editBiochemistrys/{id}', [Admin\MedicalReportsController::class, 'editBiochemistry'])->name('medical_reports.edit_biochemistry');
    Route::post('biochemistrys/upload_report/{id}', [Admin\BiochemistryController::class, 'upload_report'])->name('biochemistrys.upload_report');
    Route::get('called_patient_biochemistrys/{id}', [Admin\BiochemistryController::class, 'called_patient'])->name('biochemistrys.called_patient');
    Route::get('biochemistrys_medical_report/{id}', [Admin\BiochemistryController::class, 'confirm_report'])->name('biochemistrys.confirm_report');

    //Blood reports
    Route::get('editBloob/{id}', [Admin\MedicalReportsController::class, 'editBlood'])->name('medical_reports.edit_blood');
    //PCR reports
    Route::get('editPCR/{id}', [Admin\MedicalReportsController::class, 'editPCR'])->name('medical_reports.edit_pcr');

      //Permissions
      Route::resource('permissions', Admin\PermissionController::class);
      Route::get('createModule', [Admin\PermissionController::class, 'createModule'])->name('permissions.createModule');
      Route::post('storeModule', [Admin\PermissionController::class, 'storeModule'])->name('permissions.storeModule');

    /*//Biochemistry
    Route::resource('department_biochemistry','DepartmentBiochemistryController');
    Route::post('department_biochemistry/upload_report/{id}','MedicalReportsController@upload_report')->name('department_biochemistry.upload_report');
    Route::post('medical_reports/pdf/{id}','DepartmentBiochemistryController@pdf')->name('department_biochemistry.pdf');
    Route::post('medical_reports/pdf2/{id}','DepartmentBiochemistryController@pdf2')->name('department_biochemistry.pdf2');
    Route::post('medical_reports/pdf3/{id}','DepartmentBiochemistryController@pdf3')->name('department_biochemistry.pdf3');
    Route::post('department_biochemistry/update_culture/{id}','DepartmentBiochemistryController@update_culture')->name('department_biochemistry.update_culture');//update cultures
    Route::get('sign_medical_report/{id}','DepartmentBiochemistryController@sign')->name('department_biochemistry.sign');
    Route::get('confirm_report_department_biochemistry/{id}','DepartmentBiochemistryController@confirm_report')->name('department_biochemistry.confirm_report');
    Route::get('sign_medical_report2/{id}','DepartmentBiochemistryController@sign2')->name('department_biochemistry.sign2');
    Route::get('department_biochemistry/print_report/{id}','DepartmentBiochemistryController@print_report')->name('department_biochemistry.print_report');
    Route::get('department_biochemistry/print_report5/{id}','DepartmentBiochemistryController@print_report5')->name('department_biochemistry.print_report5');
    Route::get('department_biochemistry/print_reportgr/{id}','DepartmentBiochemistryController@print_reportgr')->name('department_biochemistry.print_reportgr');
    Route::post('department_biochemistry/send_report_mail/{id}','DepartmentBiochemistryController@send_report_mail')->name('department_biochemistry.send_report_mail');
    Route::post('department_biochemistry/bulk/delete','DepartmentBiochemistryController@bulk_delete')->name('groups.bulk_delete');
    Route::post('department_biochemistry/bulk/print_barcode','DepartmentBiochemistryController@bulk_print_barcode')->name('groups.bulk_print_barcode');
    Route::post('department_biochemistry/bulk/sign_report','DepartmentBiochemistryController@bulk_sign_report')->name('groups.bulk_sign_report');
    Route::post('department_biochemistry/bulk/print_report','DepartmentBiochemistryController@bulk_print_report')->name('groups.bulk_print_report');
    Route::post('department_biochemistry/bulk/print_report5','DepartmentBiochemistryController@bulk_print_report')->name('groups.bulk_print_report');
    Route::post('department_biochemistry/bulk/send_report_mail','DepartmentBiochemistryController@bulk_send_report_mail')->name('groups.bulk_send_report_mail');

    //Microbiology
    Route::resource('department_microbiology','DepartmentMicrobiologyController');*/

    //Health Certificate
    Route::resource('healthcertificates', Admin\HealthCertificateController::class);
    Route::get('healthcertificates/create_tests/{id}', [Admin\HealthCertificateController::class, 'create_tests'])->name('healthcertificates.create_tests');
    Route::post('healthcertificates/pdf/{id}', [Admin\HealthCertificateController::class, 'pdf'])->name('healthcertificates.pdf');
    Route::get('get_healthcertificates', [Admin\HealthCertificateController::class, 'ajax'])->name('get_healthcertificates');
    Route::post('healthcertificates/bulk/delete', [Admin\HealthCertificateController::class, 'bulk_delete'])->name('healthcertificates.bulk_delete');
    Route::get('healthcertificates/report_healthcertificate/{id}', [Admin\HealthCertificateController::class, 'report_healthcertificate'])->name('healthcertificates.report_healthcertificate');
    Route::post('healthcertificates/bulk/print_report_visit', [Admin\HealthCertificateController::class, 'bulk_print_report_visit'])->name('healthcertificates.bulk_print_report_visit');
    Route::get('healthcertificates/print_reportgr/{id}', [Admin\HealthCertificateController::class, 'print_reportgr'])->name('healthcertificates.print_reportgr');

    Route::get('healthcertificates-pdf/{id}', [Admin\HealthCertificateController::class, 'healthcertificate_pdfs'])->name('healthcertificates.hc-pdf');

    //doctors
    Route::resource('doctors', Admin\DoctorsController::class);
    Route::get('get_doctors', [Admin\DoctorsController::class, 'ajax'])->name('get_doctors');
    Route::get('doctors_export', [Admin\DoctorsController::class, 'export'])->name('doctors.export');
    Route::get('doctors_download_template', [Admin\DoctorsController::class, 'download_template'])->name('doctors.download_template');
    Route::post('doctors_import', [Admin\DoctorsController::class, 'import'])->name('doctors.import');
    Route::post('doctors/bulk/delete', [Admin\DoctorsController::class, 'bulk_delete'])->name('doctors.bulk_delete');

    //roles
    Route::resource('roles', Admin\RolesController::class);
    Route::get('get_roles', [Admin\RolesController::class, 'ajax'])->name('get_roles');
    Route::post('roles/bulk/delete', [Admin\RolesController::class, 'bulk_delete'])->name('roles.bulk_delete');

    //users
    Route::resource('users', Admin\UsersController::class);
    Route::get('get_users', [Admin\UsersController::class, 'ajax'])->name('get_users');
    Route::post('users/bulk/delete', [Admin\UsersController::class, 'bulk_delete'])->name('users.bulk_delete');

    //instruments
    Route::resource('instruments', Admin\InstrumentsController::class);
    Route::get('get_instruments', [Admin\InstrumentsController::class, 'ajax'])->name('get_instruments');
    Route::post('instruments/bulk/delete', [Admin\InstrumentsController::class, 'bulk_delete'])->name('instruments.bulk_delete');

    //laboratories
    Route::resource('laboratories', Admin\LaboratoriesController::class);
    Route::get('get_laboratories', [Admin\LaboratoriesController::class, 'ajax'])->name('get_laboratories');
    Route::post('laboratories/bulk/delete', [Admin\LaboratoriesController::class, 'bulk_delete'])->name('laboratories.bulk_delete');

    //tests price list
    Route::get('prices/tests', [Admin\PricesController::class, 'tests'])->name('prices.tests');
    Route::post('prices/tests', [Admin\PricesController::class, 'tests_submit'])->name('prices.tests_submit');
    Route::get('tests_prices_export', [Admin\PricesController::class, 'tests_prices_export'])->name('prices.tests_prices_export');
    Route::post('tests_prices_import', [Admin\PricesController::class, 'tests_prices_import'])->name('prices.tests_prices_import');

    //microbiology tests price list
    Route::get('prices/microbiology_tests', [Admin\PricesController::class, 'microbiology_tests'])->name('prices.microbiology_tests');
    Route::post('prices/microbiology_tests', [Admin\PricesController::class, 'microbiology_tests_submit'])->name('prices.microbiology_tests_submit');
    Route::get('microbiology_tests_prices_export', [Admin\PricesController::class, 'microbiology_tests_prices_export'])->name('prices.microbiology_tests_prices_export');
    Route::post('microbiology_tests_prices_import', [Admin\PricesController::class, 'microbiology_tests_prices_import'])->name('prices.microbiology_tests_prices_import');

    //cultures price list
    Route::get('prices/cultures', [Admin\PricesController::class, 'cultures'])->name('prices.cultures');
    Route::post('prices/cultures', [Admin\PricesController::class, 'cultures_submit'])->name('prices.cultures_submit');
    Route::get('cultures_prices_export', [Admin\PricesController::class, 'cultures_prices_export'])->name('prices.cultures_prices_export');
    Route::post('cultures_prices_import', [Admin\PricesController::class, 'cultures_prices_import'])->name('prices.cultures_prices_import');

    //packages price list
    Route::get('prices/packages', [Admin\PricesController::class, 'packages'])->name('prices.packages');
    Route::post('prices/packages', [Admin\PricesController::class, 'packages_submit'])->name('prices.packages_submit');
    Route::get('packages_prices_export', [Admin\PricesController::class, 'packages_prices_export'])->name('prices.packages_prices_export');
    Route::post('packages_prices_import', [Admin\PricesController::class, 'packages_prices_import'])->name('prices.packages_prices_import');

    //services price list
    Route::get('prices/services', [Admin\PricesController::class, 'services'])->name('prices.services');
    Route::post('prices/services', [Admin\PricesController::class, 'services_submit'])->name('prices.services_submit');
    Route::get('services_prices_export', [Admin\PricesController::class, 'services_prices_export'])->name('prices.services_prices_export');
    Route::post('services_prices_import', [Admin\PricesController::class, 'services_prices_import'])->name('prices.services_prices_import');

    //api prices managment
    Route::post('tests_prices_update', [Admin\PricesController::class, 'updateTestPrices'])->name('prices.updateTestPrices');
    Route::post('tests_prices_update_api', [Admin\APIController::class, 'updatePricesAPI'])->name('prices.api-updateTestPrices');
    Route::get('tests_prices_update_api_contract', [Admin\APIController::class, 'retrieveSubjects'])->name('prices.api-updateTestPricesContract');
    //update all contract price from base tables
    Route::get('price_update_contracts', [Admin\ContractsController::class, 'updateAllContractPrices'])->name('price_update.contracts');

    //accounting reports
    Route::resource('payment_methods', Admin\PaymentMethodsController::class);
    Route::get('accounting', [Admin\AccountingController::class, 'index'])->name('accounting.index');
    Route::get('generate_report', [Admin\AccountingController::class, 'generate_report'])->name('accounting.generate_report');
    Route::get('doctor_report', [Admin\AccountingController::class, 'doctor_report'])->name('accounting.doctor_report');
    Route::get('generate_doctor_report', [Admin\AccountingController::class, 'generate_doctor_report'])->name('accounting.generate_doctor_report');

    //chat
    Route::get('chat', [Admin\ChatController::class, 'index'])->name('chat.index');

    //visits
    Route::resource('visits', Admin\VisitsController::class);
    Route::get('visits/create_tests/{id}', [Admin\VisitsController::class, 'create_tests'])->name('visits.create_tests');
    Route::post('visits/pdf/{id}', [Admin\VisitsController::class, 'pdf'])->name('visits.pdf');
    Route::post('visits/pdf2/{id}', [Admin\VisitsController::class, 'pdf2'])->name('visits2.pdf');
    Route::post('visits/pdfv3/{id}', [Admin\VisitsController::class, 'pdfv3'])->name('visitspdfv3.pdf');
    Route::post('visits/pdfv31/{id}', [Admin\VisitsController::class, 'pdfv31'])->name('visitspdfv31.pdf');
    Route::get('get_visits', [Admin\VisitsController::class, 'ajax'])->name('get_visits');
    Route::post('visits/bulk/delete', [Admin\VisitsController::class, 'bulk_delete'])->name('visits.bulk_delete');
    Route::get('visits/report_visit/{visit_id}', [Admin\VisitsController::class, 'report_visit'])->name('visits.report_visit');
    Route::get('visits/report_visit2/{visit_id}', [Admin\VisitsController::class, 'report_visit2'])->name('visits.report_visit2');
    Route::get('visits/report_visit3/{visit_id}', [Admin\VisitsController::class, 'report_visit3'])->name('visits.report_visit3');
    Route::get('visits/report_visit4/{visit_id}', [Admin\VisitsController::class, 'report_visit4'])->name('visits.report_visit4');
    Route::post('visits/bulk/print_report_visit', [Admin\VisitsController::class, 'bulk_print_report_visit'])->name('visits.bulk_print_report_visit');
    Route::get('sign_visit/{id}', [Admin\VisitsController::class, 'sign'])->name('visits.sign');
    Route::get('visit-pdf/{id}', [Admin\VisitsController::class, 'visits_pdfs'])->name('visit_reports.visit-pdf');
    Route::get('visit-pdf2/{id}', [Admin\VisitsController::class, 'visits_pdfs_recepsion'])->name('visit_reports2.visit-pdf');

    // //Vistis-Dr
    // Route::get('visits-dr','VisitsController@indexDr')->name('visits.indexDr');
    // Route::get('get_visitsDr','VisitsController@ajaxDr')->name('get_visitsDr');

    //Vistis-Dr
    Route::resource('visitsDr', Admin\VisitDrController::class);
    Route::get('get_visitsDr', [Admin\VisitDrController::class, 'ajaxDr'])->name('get_visitsDr');
    Route::get('sign_visitDr/{id}', [Admin\VisitDrController::class, 'sign'])->name('visitsDr.sign');

    //Services
    Route::resource('services', Admin\ServicesController::class);
    Route::get('get_services', [Admin\ServicesController::class, 'ajax'])->name('get_services');

    //Pathology
    Route::resource('pathologys', Admin\PathologyController::class);
    Route::get('get_pathologys', [Admin\PathologyController::class,'ajax'])->name('get_pathologys');
    Route::get('pathology-pdf/{id}', [Admin\PathologyController::class,'pathologyPdf'])->name('pathologys.pathology-pdf');
    Route::get('pathology2-pdf/{id}', [Admin\PathologyController::class,'pathology2Pdf'])->name('pathologys.pathology2-pdf');
    Route::get('cytological-pdf/{id}', [Admin\PathologyController::class,'cytologicalPdf'])->name('pathologys.cytological-pdf');
    Route::get('paptest-pdf/{id}', [Admin\PathologyController::class,'paptestPdf'])->name('pathologys.paptest-pdf');
    Route::get('create-Cytology', [Admin\PathologyController::class,'createCytology'])->name('pathologys.createCytology');
    Route::get('create-PapTest', [Admin\PathologyController::class,'createPapTest'])->name('pathologys.createPapTest');
    //Cytology
    Route::get('edit-Cytology/{id}/edit', [Admin\PathologyController::class, 'editCytology'])->name('pathologys.editCytology');
    Route::put('update-Cytology/{id}', [Admin\PathologyController::class, 'updateCytology'])->name('pathologys.updateCytology');
    //PapTest
    Route::post('papTest', [Admin\PathologyController::class, 'storePapTest'])->name('pathologys.storePapTest');
    Route::get('edit-PapTest/{id}/edit', [Admin\PathologyController::class, 'editPapTest'])->name('pathologys.editPapTest');
    Route::put('update-PapTest/{id}', [Admin\PathologyController::class, 'updatePapTest'])->name('pathologys.updatePapTest');


    //appointments
    Route::resource('appointments', Admin\AppointmentsController::class);
    Route::get('appointments/create_tests/{id}', [Admin\AppointmentsController::class, 'create_tests'])->name('appointments.create_tests');
    Route::post('appointments/pdf/{id}', [Admin\AppointmentsController::class, 'pdf'])->name('appointments.pdf');
    Route::post('appointments/pdf2/{id}', [Admin\AppointmentsController::class, 'pdf2'])->name('appointments2.pdf');
    Route::get('get_appointments', [Admin\AppointmentsController::class, 'ajax'])->name('get_appointments');
    Route::post('appointments/bulk/delete', [Admin\AppointmentsController::class, 'bulk_delete'])->name('appointments.bulk_delete');
    Route::get('appointments/report_appointment/{visit_id}', [Admin\AppointmentsController::class, 'report_appointment'])->name('appointments.report_appointment');
    Route::get('appointments/report_appointment2/{visit_id}', [Admin\AppointmentsController::class, 'report_appointment2'])->name('appointments.report_appointment2');
    Route::post('appointments/bulk/print_report_appointment', [Admin\AppointmentsController::class, 'bulk_print_report_appointment'])->name('appointments.bulk_print_report_appointment');

    //branches
    Route::resource('branches', Admin\BranchesController::class);
    Route::get('get_branches', [Admin\BranchesController::class, 'ajax'])->name('get_branches');
    Route::post('branches/bulk/delete', [Admin\BranchesController::class, 'bulk_delete'])->name('branches.bulk_delete');

     //Vat
     Route::resource('vat', Admin\VatController::class);

    //contracts
    Route::resource('contracts', Admin\ContractsController::class);
    Route::get('get_contracts', [Admin\ContractsController::class, 'ajax'])->name('get_contracts');
    Route::post('contracts/bulk/delete', [Admin\ContractsController::class, 'bulk_delete'])->name('contracts.bulk_delete');
    Route::post('contract_price_import', [Admin\ContractsController::class, 'import'])->name('contracts_price.import');

    //expenses
    Route::resource('expenses', Admin\ExpensesController::class);
    Route::get('get_expenses', [Admin\ExpensesController::class, 'ajax'])->name('get_expenses');
    Route::post('expenses/bulk/delete', [Admin\ExpensesController::class, 'bulk_delete'])->name('expenses.bulk_delete');

    //expense categories
    Route::resource('expense_categories', Admin\ExpenseCategoriesController::class);
    Route::get('get_expense_categories', [Admin\ExpenseCategoriesController::class, 'ajax'])->name('get_expense_categories');
    Route::post('expense_categories/bulk/delete', [Admin\ExpenseCategoriesController::class, 'bulk_delete'])->name('expense_categories.bulk_delete');

    //backups
    Route::resource('backups', Admin\BackupsController::class);

    //activity logs
    Route::resource('activity_logs', Admin\ActivityLogsController::class);
    Route::post('activity_logs_clear', [Admin\ActivityLogsController::class, 'clear'])->name('activity_logs.clear');
    Route::get('get_activity_logs', [Admin\ActivityLogsController::class, 'ajax'])->name('get_activity_logs');

    //settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [Admin\SettingsController::class, 'index'])->name('index');
        Route::post('info', [Admin\SettingsController::class, 'info_submit'])->name('info_submit');
        Route::post('emails', [Admin\SettingsController::class, 'emails_submit'])->name('emails_submit');
        Route::post('reports', [Admin\SettingsController::class, 'reports_submit'])->name('reports_submit');
        Route::post('sms', [Admin\SettingsController::class, 'sms_submit'])->name('sms_submit');
        Route::post('whatsapp', [Admin\SettingsController::class, 'whatsapp_submit'])->name('whatsapp_submit');
        Route::post('api_keys', [Admin\SettingsController::class, 'api_keys_submit'])->name('api_keys_submit');
        Route::post('barcode', [Admin\SettingsController::class, 'barcode_submit'])->name('barcode_submit');
    });

    //inventory module
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('suppliers', Admin\Inventory\SuppliersController::class);
        Route::post('suppliers/bulk/delete', [Admin\Inventory\SuppliersController::class, 'bulk_delete'])->name('suppliers.bulk_delete');
        Route::resource('products', Admin\Inventory\ProductsController::class);
        Route::post('products/bulk/delete', [Admin\Inventory\ProductsController::class, 'bulk_delete'])->name('products.bulk_delete');
        Route::resource('purchases', Admin\Inventory\PurchasesController::class);
        Route::post('purchases/bulk/delete', [Admin\Inventory\PurchasesController::class, 'bulk_delete'])->name('purchases.bulk_delete');
        Route::resource('adjustments', Admin\Inventory\AdjustmentsController::class);
        Route::post('adjustments/bulk/delete', [Admin\Inventory\AdjustmentsController::class, 'bulk_delete'])->name('adjustments.bulk_delete');
        Route::resource('transfers', Admin\Inventory\TransfersController::class);
        Route::post('transfers/bulk/delete', [Admin\Inventory\TransfersController::class, 'bulk_delete'])->name('transfers.bulk_delete');
        Route::get('product_alerts', [Admin\Inventory\ProductsController::class, 'product_alerts']);
    });

    //Reports module
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('accounting', [Admin\ReportsController::class, 'accounting'])->name('accounting');
        Route::get('patient', [Admin\ReportsController::class, 'patient'])->name('patient');
        Route::get('doctor', [Admin\ReportsController::class, 'doctor'])->name('doctor');
        Route::get('supplier', [Admin\ReportsController::class, 'supplier'])->name('supplier');
        Route::get('purchase', [Admin\ReportsController::class, 'purchase'])->name('purchase');
        Route::get('inventory', [Admin\ReportsController::class, 'inventory'])->name('inventory');
        Route::get('product', [Admin\ReportsController::class, 'product'])->name('product');
        Route::get('hlresult', [Admin\ReportsController::class, 'hlresult'])->name('hlresult');
        Route::get('branch_products', [Admin\ReportsController::class, 'branch_products'])->name('branch_products');
    });


        //Point Of Sale
        Route::resource('pointofsales', Admin\PointOfSaleController::class);

        //POS Transactions
        Route::resource('pos_transactions', Admin\PosTransactionController::class);
        Route::post('pos-transactions/bulk-update', [Admin\PosTransactionController::class, 'bulkUpdate'])->name('pos-transactions.bulk-update');
        Route::post('pos-transactions/storecashflow', [Admin\PosTransactionController::class, 'storecashflow'])->name('pos-transactions.storecashflow');
        Route::get('/generate-pdf', [Admin\PosTransactionController::class, 'generatePDF'])->name('pos_transactions.pdf_transactions');
        Route::post('/admin/pos_transactions/generate_report', [Admin\PosTransactionController::class, 'generateReport'])->name('pos_transactions.generate_report');
        Route::post('/admin/pos_transactions/generate_pdf', [Admin\PosTransactionController::class, 'generatePDF'])->name('pos_transactions.generate_pdf');

        Route::get('report_x_z/sales_report', [Admin\PosTransactionController::class, 'salesReport'])->name('pos_transactions.sales_report');

    //translations
    Route::resource('translations', Admin\TranslationsController::class);
});
