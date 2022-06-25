<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/employees', [EmployeeController::class, 'showSearch'])->name('employees');

Route::get('/employees/register', [EmployeeController::class, 'showRegister'])->name('employees');

Route::post('/employees/register', [EmployeeController::class, 'register'])->name('employees');

Route::get('/orders', [OrderController::class, 'showSearch'])->name('orders');

Route::get('/orders/register', [OrderController::class, 'showRegister'])->name('orders');

Route::post('/orders/register', [OrderController::class, 'register'])->name('orders');
