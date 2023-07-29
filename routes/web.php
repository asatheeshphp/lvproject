<?php

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

//default controller
use App\Http\Controllers;

//route for load products page
Route::controller(ProductController::class)->group(static function (): void {
    Route::get('/products','index');
});

//route for load product details along with product id
// Route::controller(ProductdetailsController::class)->group(static function (): void {
//     Route::get('productdetails/{id}','show');
// });

use App\Http\Controllers\ProductdetailsController;
Route::get('/productdetails/{id}', [ProductdetailsController::class, 'show'])->name('productdetails.show');


use App\Http\Controllers\PaymentController;
//route for process the payment 
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');