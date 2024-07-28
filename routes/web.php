<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminActiveEmergencyController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*/
Route::get('/', function () {
    return view('Admin/home1');
});
Route::get('/charity_browse', [AdminActiveEmergencyController::class, 'browse_charity'])->name('charity_browse');
Route::get('/browse_charity_details/{id}', [AdminActiveEmergencyController::class, 'show'])->name('browse_charity_details');

Route::get('/active_emergency_status', [AdminActiveEmergencyController::class, 'index'])->name('active_emergency_status');
Route::get('/factor_emergency_status', [AdminActiveEmergencyController::class, 'index_factor'])->name('factor_emergency_status');

Route::post('/set_active_emergency_status', [AdminActiveEmergencyController::class, 'active_emergency_status'])->name('set_active_emergency_status');
Route::post('/set_factor_emergency_status', [AdminActiveEmergencyController::class, 'put_factor'])->name('set_factor_emergency_status');


Route::post('/unableemergency/{id}', [AdminActiveEmergencyController::class, 'unableemergency'])->name('unableemergency');

Route::get('/get_emergency', [AdminActiveEmergencyController::class, 'get_emergency'])->name('get_emergency');

Route::get('register', [UserController::class, 'createUser']);
Route::post('/home',[BeneficiaryController::class, 'beneficiaryorderfromsection']);
