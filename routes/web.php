<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('pages.dashboard');
// });







Route::post('user_add', [userController::class, 'store'])->name('user_add')->middleware('auth');
Route::get('/', [userController::class, 'index'])->name('user.view')->middleware('auth');
Route::get('user_detail', [userController::class, 'UserDetail'])->name('user_detail')->middleware('auth');
Route::delete('user_delete', [userController::class, 'destroy'])->name('user_delete')->middleware('auth');
Route::post('user_edit', [userController::class, 'show'])->name('user_edit')->middleware('auth');
Route::post('user_update', [userController::class, 'update'])->name('user_update')->middleware('auth');
Route::post('/user/validate', [CustomerController::class, 'validateField'])->name('user.validate')->middleware('auth');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


Route::get('logout', [userController::class, 'logout'])->name('logout')->middleware('auth');


// Customer Controller

Route::get('customer', [CustomerController::class, 'index'])->name('customer')->middleware('auth');
Route::post('customers', [CustomerController::class, 'store'])->name('customers')->middleware('auth');
Route::post('/customer/validate', [CustomerController::class, 'validateField'])->name('customer.validate')->middleware('auth');
Route::post('customer_edit', [CustomerController::class, 'show'])->name('customer_edit')->middleware('auth');
Route::post('customer_update', [CustomerController::class, 'update'])->name('customer_update')->middleware('auth');
Route::post('/customer/delete', [CustomerController::class, 'destroy'])->name('destroy')->middleware('auth');
