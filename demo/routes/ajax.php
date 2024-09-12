<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

Route::prefix('ajax')->name('ajax.')->middleware('Ajax')->group(function () {

    //get patients
    Route::get('get_patient_by_code', [AjaxController::class, 'get_patient_by_code'])->name('get_patient_by_code')->middleware('Admin');
    Route::get('get_patient_by_name', [AjaxController::class, 'get_patient_by_name'])->name('get_patient_by_name')->middleware('Admin');

    //get patient
    Route::get('get_patient', [AjaxController::class, 'get_patient'])->name('get_patient');

    //create patient
    Route::post('create_patient', [AjaxController::class, 'create_patient'])->name('create_patient')->middleware('Admin');

    //edit patient
    Route::post('edit_patient/{id}', [AjaxController::class, 'edit_patient'])->name('edit_patient')->middleware('Admin');

    //get tests
    Route::get('get_tests', [AjaxController::class, 'get_tests'])->name('get_tests');

    //get microbiology tests
    Route::get('get_microbiology_tests', [AjaxController::class, 'get_microbiology_tests'])->name('get_microbiology_tests');

    //delete test
    Route::get('delete_test/{test_id}', [AjaxController::class, 'delete_test'])->name('delete_test')->middleware('Admin');

    //delete option
    Route::get('delete_option/{option_id}', [AjaxController::class, 'delete_option'])->name('delete_option')->middleware('Admin');

    //delete option micro
    Route::get('delete_option_mikro/{option_id}', [AjaxController::class, 'delete_option_mikro'])->name('delete_option_mikro')->middleware('Admin');

    //get cultures
    Route::get('get_cultures', [AjaxController::class, 'get_cultures'])->name('get_cultures');

    //get doctors
    Route::get('get_doctors', [AjaxController::class, 'get_doctors'])->name('get_doctors')->middleware('Admin');

    //get instruments
    Route::get('get_instruments', [AjaxController::class, 'get_instruments'])->name('get_instruments')->middleware('Admin');

    //get laboratories
    Route::get('get_laboratories', [AjaxController::class, 'get_laboratories'])->name('get_laboratories')->middleware('Admin');

    //create doctor
    Route::post('create_doctor', [AjaxController::class, 'create_doctor'])->name('create_doctor')->middleware('Admin');

    //create instrument
    Route::post('create_instrument', [AjaxController::class, 'create_instrument'])->name('create_instrument')->middleware('Admin');

    //create laboratory
    Route::post('create_laboratory', [AjaxController::class, 'create_laboratory'])->name('create_laboratory')->middleware('Admin');

    //get roles
    Route::get('get_roles', [AjaxController::class, 'get_roles'])->name('get_roles')->middleware('Admin');

    //get online users
    Route::get('online_admins', [AjaxController::class, 'online_admins'])->name('online_admins')->middleware('Admin');
    Route::get('online_patients', [AjaxController::class, 'online_patients'])->name('online_patients')->middleware('Admin');

    //get chat
    Route::get('get_chat/{id}', [AjaxController::class, 'get_chat'])->name('get_chat')->middleware('Admin');
    Route::get('chat_unread/{id}', [AjaxController::class, 'chat_unread'])->name('chat_unread')->middleware('Admin');
    Route::post('send_message/{id}', [AjaxController::class, 'send_message'])->name('send_message')->middleware('Admin');

    //change visit status
    Route::post('change_visit_status/{id}', [AjaxController::class, 'change_visit_status'])->name('change_visit_status')->middleware('Admin');

    //change pathology status
    Route::post('change_pathology_status/{id}', [AjaxController::class, 'change_pathology_status'])->name('change_pathology_status')->middleware('Admin');

    //change appointment status
    Route::post('change_appointment_status/{id}', [AjaxController::class, 'change_appointment_status'])->name('change_appointment_status')->middleware('Admin');

    //change lang status
    Route::post('change_lang_status/{id}', [AjaxController::class, 'change_lang_status'])->name('change_lang_status')->middleware('Admin');

    //add category
    Route::post('add_expense_category', [AjaxController::class, 'add_expense_category'])->name('add_expense_category')->middleware('Admin');

    //get unread messages
    Route::get('get_unread_messages', [AjaxController::class, 'get_unread_messages'])->name('get_unread_messages')->middleware('Admin');
    Route::get('get_unread_messages_count/{id}', [AjaxController::class, 'get_unread_messages_count'])->name('get_unread_messages_count')->middleware('Admin');

    //get my messages
    Route::get('get_my_messages/{id}', [AjaxController::class, 'get_my_messages'])->name('get_my_messages')->middleware('Admin');

    //get new visits
    Route::get('get_new_visits', [AjaxController::class, 'get_new_visits'])->name('get_new_visits')->middleware('Admin');

    //get new appointments
    Route::get('get_new_appointments', [AjaxController::class, 'get_new_appointments'])->name('get_new_appointments')->middleware('Admin');

    //load more messages
    Route::get('load_more/{user_id}/{message_id}', [AjaxController::class, 'load_more'])->name('load_more')->middleware('Admin');

    //get current patient
    Route::get('get_current_patient', [AjaxController::class, 'get_current_patient'])->name('get_current_patient')->middleware('Patient');

    //get categories
    Route::get('get_categories', [AjaxController::class, 'get_categories'])->name('get_categories')->middleware('Admin');

    //get contracts
    Route::get('get_contracts', [AjaxController::class, 'get_contracts'])->name('get_contracts')->middleware('Admin');

    //get payment methods
    Route::get('get_payment_methods', [AjaxController::class, 'get_payment_methods'])->name('get_payment_methods')->middleware('Admin');

    //create payment method
    Route::post('create_payment_method', [AjaxController::class, 'create_payment_method'])->name('create_payment_method')->middleware('Admin');

    //get statistics
    Route::get('get_statistics', [AjaxController::class, 'get_statistics'])->name('get_statistics')->middleware('Admin');

    //select2 tests
    Route::get('get_tests_select2', [AjaxController::class, 'get_tests_select2'])->name('get_tests_select2');

    //select2 cultures
    Route::get('get_cultures_select2', [AjaxController::class, 'get_cultures_select2'])->name('get_cultures_select2');

    //select2 packages
    Route::get('get_packages_select2', [AjaxController::class, 'get_packages_select2'])->name('get_packages_select2');

    //select2 antibiotics
    Route::get('get_antibiotics_select2', [AjaxController::class, 'get_antibiotics_select2'])->name('get_antibiotics_select2');

    //select2 doctors
    Route::get('get_doctors_select2', [AjaxController::class, 'get_doctors_select2'])->name('get_doctors_select2');

    //select2 branches
    Route::get('get_branches_select2', [AjaxController::class, 'get_branches_select2'])->name('get_branches_select2');

    //get contract
    Route::get('get_contract/{id}', [AjaxController::class, 'get_contract'])->name('get_contract')->middleware('Admin');

    //select2 products
    Route::get('get_products_select2', [AjaxController::class, 'get_products_select2'])->name('get_products_select2');

    //select2 suppliers
    Route::get('get_suppliers_select2', [AjaxController::class, 'get_suppliers_select2'])->name('get_suppliers_select2');

    //stock alert
    Route::get('get_stock_alerts', [AjaxController::class, 'get_stock_alerts'])->name('get_stock_alerts')->middleware('Admin');

    //get all branches
    Route::get('get_all_branches', [AjaxController::class, 'get_all_branches'])->name('get_all_branches');

    //get income chart
    Route::get('get_income_chart/{month}/{year}', [AjaxController::class, 'get_income_chart'])->name('get_income_chart')->middleware('Admin');

    //get best income packages
    Route::get('get_best_income_packages', [AjaxController::class, 'get_best_income_packages'])->name('get_best_income_packages')->middleware('Admin');

    //get best income tests
    Route::get('get_best_income_tests', [AjaxController::class, 'get_best_income_tests'])->name('get_best_income_tests')->middleware('Admin');

    //get best income cultures
    Route::get('get_best_income_cultures', [AjaxController::class, 'get_best_income_cultures'])->name('get_best_income_cultures')->middleware('Admin');

    //change admin theme
    Route::get('change_admin_theme', [AjaxController::class, 'change_admin_theme'])->name('change_admin_theme');

    //change patient theme
    Route::get('change_patient_theme', [AjaxController::class, 'change_patient_theme'])->name('change_patient_theme');

    //select2 timezones
    Route::get('get_timezones_select2', [AjaxController::class, 'get_timezones_select2'])->name('get_timezones_select2')->middleware('Admin');

    //get age
    Route::get('get_age/{dob}', [AjaxController::class, 'get_age'])->name('get_age');

    //get dob
    Route::get('get_dob/{age}', [AjaxController::class, 'get_dob'])->name('get_dob');

    //get countries
    Route::get('get_countries', [AjaxController::class, 'get_countries'])->name('get_countries');

    //delete patient avatar
    Route::get('delete_patient_avatar/{patient_id}', [AjaxController::class, 'delete_patient_avatar'])->name('delete_patient_avatar')->middleware('Admin');

    //delete patient avatar
    Route::get('delete_patient_avatar_by_patient', [AjaxController::class, 'delete_patient_avatar_by_patient'])->name('delete_patient_avatar_by_patient')->middleware('Patient');

    //get users
    Route::get('get_users', [AjaxController::class, 'get_users'])->name('get_users')->middleware('Admin');

    //delete user avatar
    Route::get('delete_user_avatar_by_user', [AjaxController::class, 'delete_user_avatar_by_user'])->name('delete_user_avatar_by_user')->middleware('Admin');

    //get invoice tests
    Route::get('get_invoice_tests', [AjaxController::class, 'get_invoice_tests'])->name('get_invoice_tests')->middleware('Admin');

    //get test
    Route::get('get_invoice_test', [AjaxController::class, 'get_invoice_test'])->name('get_invoice_test')->middleware('Admin');

    //get invoice cultures
    Route::get('get_invoice_cultures', [AjaxController::class, 'get_invoice_cultures'])->name('get_invoice_cultures')->middleware('Admin');

    //get culture
    Route::get('get_invoice_culture', [AjaxController::class, 'get_invoice_culture'])->name('get_invoice_culture')->middleware('Admin');

    //get invoice packages
    Route::get('get_invoice_packages', [AjaxController::class, 'get_invoice_packages'])->name('get_invoice_packages')->middleware('Admin');

    //get package
    Route::get('get_invoice_package', [AjaxController::class, 'get_invoice_package'])->name('get_invoice_package')->middleware('Admin');

    //get langues
    Route::get('get_languages', [AjaxController::class, 'get_languages'])->name('get_languages')->middleware('Admin');

    //select2 services
    Route::get('get_services_select2', [AjaxController::class, 'get_services_select2'])->name('get_services_select2');
    //get invoice service
    Route::get('get_invoice_services', [AjaxController::class, 'get_invoice_services'])->name('get_invoice_services')->middleware('Admin');
    //get service
    Route::get('get_invoice_service', [AjaxController::class, 'get_invoice_service'])->name('get_invoice_service')->middleware('Admin');

    //get invoice  microbiology tests
    Route::get('get_invoice_microbiology_tests', [AjaxController::class, 'get_invoice_microbiology_tests'])->name('get_invoice_microbiology_tests')->middleware('Admin');

    //get  microbiology test
    Route::get('get_invoice_microbiology_test', [AjaxController::class, 'get_invoice_microbiology_test'])->name('get_invoice_microbiology_test')->middleware('Admin');

});
