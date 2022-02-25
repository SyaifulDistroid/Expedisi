<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PrintController;

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

Route::get('/', function () {
    return view('welcome');
});

//
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('transaction', TransactionController::class);
    Route::post('transaction.databarang', [TransactionController::class, 'databarang'])->name('transaction.databarang');
    Route::post('transaction.storeprint', [TransactionController::class, 'storePrint'])->name('transaction.storeprint');
    Route::post('transaction.clearprint', [TransactionController::class, 'clearprint'])->name('transaction.clearprint');

    Route::resource('print', PrintController::class);
    Route::get('print.print', [PrintController::class, 'print'])->name('print.print');

    Route::delete('transaction.databarang/{id}/{idtransaction}', [TransactionController::class, 'destroydatabarang'])->name('transaction.databarang');
});
