<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('layout/home');
});
Route::get('/setting', function () {
    return view('settingApplication/settingApplication');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware('adminLogin')->prefix('admin')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:list_user');
        Route::get('/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:add_user');
        Route::post('/create', [UserController::class, 'store'])->name('user.store')->middleware('permission:add_user');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:edit_user');
        Route::post('/{id}/edit', [UserController::class, 'update'])->name('user.update')->middleware('permission:edit_user');
        Route::get('/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:delete_user');
        Route::get('/changepassword', [UserController::class, 'changepasswordform'])->name('user.changepasswordform');
        Route::post('/changepassword/{id}', [UserController::class, 'changepassword'])->name('user.changepassword');
        Route::get('/changeprofile', [UserController::class, 'changeprofileform'])->name('user.changeprofileform');
        Route::post('/changeprofile/{id}', [UserController::class, 'changeprofile'])->name('user.changeprofile');
    });
});
