<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SymptonController;
use App\Http\Controllers\PrescriptionMedicineController;

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

Route::prefix('admin')->group(function(){
    Route::prefix('prescription')->group(function(){
        Route::get('',[PrescriptionController::class,'index'])->name('prescription.index');
        Route::get('create',[PrescriptionController::class,'create'])->name('prescription.create');
        Route::post('store',[PrescriptionController::class,'store'])->name('prescription.store');
    });
    Route::prefix('sympton')->group(function (){
        Route::post('add-sympton',[SymptonController::class,'addSympton']);
    });

    Route::prefix('prescription-medicine')->group(function (){
        Route::post('add-prescription-medicine',[PrescriptionMedicineController::class,'addPrescriptionMedicine'])->name('addPrescriptionMedicine');
        Route::delete('delete-prescription-medicine/{id}',[PrescriptionMedicineController::class,'delete'])->name('PrescriptionMedicine.delete');

    });


});
