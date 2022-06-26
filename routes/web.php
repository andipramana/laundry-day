<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::any('/', function(){
    return View::make('pages/dashboard/index');
});

Route::get('/employees', [EmployeeController::class, 'showSearch'])->name('employees');

Route::get('/employees/register', [EmployeeController::class, 'showRegister'])->name('employeesShowRegister');

Route::post('/employees/register', [EmployeeController::class, 'register'])->name('employeesRegister');

Route::get('/orders', [OrderController::class, 'showSearch'])->name('orders');

Route::get('/orders/register', [OrderController::class, 'showRegister'])->name('ordersShowRegister');

Route::post('/orders/register', [OrderController::class, 'register'])->name('ordersRegister');

Route::get('/orders/process', [OrderController::class, 'process'])->name('ordersProcess');

Route::get('/orders/finddata', [OrderController::class, 'finddata'])->name('ordersFindData');
