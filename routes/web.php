<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SettingAppController;
use App\Http\Controllers\SymptonController;
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

    });
    Route::prefix('sympton')->group(function (){
        Route::get('',[SymptonController::class,'index'])->name('sympton.index');
        Route::post('add-sympton',[SymptonController::class,'addSympton']);
        Route::post('/add-sympton',[SymptonController::class,'store'])->name('sympton.store');
        Route::get('/{id}/edit',[SymptonController::class,'edit']);
        Route::post('/{id}/edit',[SymptonController::class,'update']);
        Route::delete('/{id}/destroy',[SymptonController::class,'destroy'])->name('sympton.destroy');
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
