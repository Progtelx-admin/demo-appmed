<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Patient;
use Illuminate\Support\Facades\Route;

//patient authentication
Route::prefix('/')->middleware('PatientGuest')->name('patient.auth.')->group(function () {

    //register
    Route::get('register', [Auth\PatientController::class, 'showRegistrationForm'])->name('register');
    Route::post('register_submit', [Auth\PatientController::class, 'register_submit'])->name('register_submit');
    //login
    Route::get('/', [Auth\PatientController::class, 'showLoginForm'])->name('login');
    Route::post('/login_submit', [Auth\PatientController::class, 'login_submit'])->name('login_submit');
    //send mail patient code
    Route::get('/mail', [Auth\PatientController::class, 'showMailForm'])->name('mail');
    Route::post('/mail_submit', [Auth\PatientController::class, 'mail_submit'])->name('mail_submit');
    //quick login patient
    Route::get('patient/login/{code}', [Auth\PatientController::class, 'login_patient'])->name('login_by_code');

});

//logout patient
Route::post('/logout', [Auth\PatientController::class, 'logout'])->name('patient.logout');

//patient pages
Route::prefix('patient')->middleware('Patient')->name('patient.')->group(function () {

    //dashboard
    Route::get('/', [Patient\IndexController::class, 'index'])->name('index');

    //get reports and receipts
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [Patient\GroupsController::class, 'index'])->name('index');
        Route::get('/reports/{id}', [Patient\GroupsController::class, 'reports'])->name('reports');
        Route::get('/receipt/{id}', [Patient\GroupsController::class, 'receipt'])->name('receipt');
        Route::post('/reports/pdf/{id}', [Patient\GroupsController::class, 'pdf'])->name('pdf');
    });
    //get patient groups
    Route::get('get_patient_groups', [Patient\GroupsController::class, 'ajax'])->name('get_patient_groups');

    //profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [Patient\ProfileController::class, 'edit'])->name('edit');
        Route::post('/', [Patient\ProfileController::class, 'update'])->name('update');
    });

    //visits
    Route::resource('visits', Patient\VisitsController::class);

    //branches
    Route::resource('branches', Patient\BranchesController::class);

    //tests library
    Route::resource('tests_library', Patient\TestsLibraryController::class);
    Route::get('get_analyses', [Patient\TestsLibraryController::class, 'get_analyses']);
    Route::get('get_cultures', [Patient\TestsLibraryController::class, 'get_cultures']);
    Route::get('get_packages', [Patient\TestsLibraryController::class, 'get_packages']);

});
