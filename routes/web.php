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

Route::get('/employees/modify/{id}', [EmployeeController::class, 'showModify'])->name('employeesShowModify');

Route::post('/employees/modify', [EmployeeController::class, 'modify'])->name('employeesModify');

Route::get('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('employeesDelete');

Route::get('/orders', [OrderController::class, 'showSearch'])->name('orders');

Route::get('/orders/register', [OrderController::class, 'showRegister'])->name('ordersShowRegister');

Route::post('/orders/register', [OrderController::class, 'register'])->name('ordersRegister');

Route::get('/orders/process', [OrderController::class, 'process'])->name('ordersProcess');

Route::get('/orders/finddata', [OrderController::class, 'finddata'])->name('ordersFindData');

Route::get('/orders/createdummy', [OrderController::class, 'createDummy'])->name('ordersCreateDummy');
