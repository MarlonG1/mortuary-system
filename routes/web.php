<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'administration', 'auth' => 'middleware'], function () {

    Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [ViewController::class, 'customers'])->name('customers');
    Route::get('/products', [ViewController::class, 'products'])->name('products');
    Route::get('/categories', [ViewController::class, 'categories'])->name('categories');
    Route::get('/employees', [ViewController::class, 'employees'])->name('employees');
    Route::get('/services', [ViewController::class, 'services'])->name('services');
    Route::get('/sales', [ViewController::class, 'sales'])->name('sales');
    Route::get('/calendar', [ViewController::class, 'calendar'])->name('calendar');
    Route::get('/viewTicket/{id}', [ReportController::class, 'viewTicket'])->name('viewTicket');
});

Route::get('/login', [ViewController::class, 'login'])->name('login');

Route::get('/test', function () {
    return view('test');
});
