<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SettingAppController;
use App\Http\Controllers\SymptonController;

use App\Http\Controllers\PrescriptionMedicineController;

use RealRashid\SweetAlert\Facades\Alert;



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


Route::prefix('admin')->group(function(){
    Route::prefix('prescription')->group(function(){
        Route::get('',[PrescriptionController::class,'index'])->name('prescription.index');
        Route::get('create',[PrescriptionController::class,'create'])->name('prescription.create');
        Route::post('store',[PrescriptionController::class,'store'])->name('prescription.store');
    });
    Route::prefix('sympton')->group(function (){
        Route::get('',[SymptonController::class,'index'])->name('sympton.index');
        Route::post('add-sympton',[SymptonController::class,'addSympton']);
        Route::post('/add-sympton',[SymptonController::class,'store'])->name('sympton.store');
        Route::get('/{id}/edit',[SymptonController::class,'edit']);
        Route::post('/{id}/edit',[SymptonController::class,'update']);
        Route::delete('/{id}/destroy',[SymptonController::class,'destroy'])->name('sympton.destroy');
    });


    Route::prefix('prescription-medicine')->group(function (){
        Route::post('add-prescription-medicine',[PrescriptionMedicineController::class,'addPrescriptionMedicine'])->name('addPrescriptionMedicine');
        Route::delete('delete-prescription-medicine/{id}',[PrescriptionMedicineController::class,'delete'])->name('PrescriptionMedicine.delete');

    });



    Route::prefix('setting')->group(function(){
        Route::get('/',[SettingAppController::class,'index'])->name('setting.index');
        Route::get('/create',[SettingAppController::class,'create'])->name('setting.create');
        Route::post('/create',[SettingAppController::class,'store'])->name('setting.store');
        Route::get('/{id}/edit',[SettingAppController::class,'edit'])->name('setting.edit');
        Route::post('/{id}/edit',[SettingAppController::class,'update'])->name('setting.update');
        Route::get('/{id}/destroy',[SettingAppController::class,'destroy'])->name('setting.destroy');
    });

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
