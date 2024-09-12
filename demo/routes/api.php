<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//authorization
Route::post('register', [Auth\ApiController::class, 'register'])->name('register');
Route::post('login', [Auth\ApiController::class, 'login'])->name('login');
Route::post('forget_code', [Auth\ApiController::class, 'forget_code']);

//patient dashboard
Route::prefix('patient')->middleware('auth:api')->group(function () {
    Route::get('dashboard', [Api\ProfileController::class, 'dashboard']);
    Route::post('update_profile', [Api\ProfileController::class, 'update_profile']);
    Route::get('group_tests', [Api\GroupTestsController::class, 'group_tests']);
    Route::post('visit', [Api\VisitsController::class, 'store']);
    Route::get('branches', [Api\BranchesController::class, 'index']);
    Route::get('tests', [Api\TestsLibraryController::class, 'tests']);
    Route::get('cultures', [Api\TestsLibraryController::class, 'cultures']);
    Route::get('packages', [Api\TestsLibraryController::class, 'packages']);
});

//get countries
Route::get('get_countries', [Api\HomeController::class, 'get_countries']);
