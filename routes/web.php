<?php

use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LotsController;
use App\Http\Controllers\MedCategoryController;
use App\Http\Controllers\MedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SettingAppController;
use App\Http\Controllers\SymptonController;
use App\Http\Controllers\PrescriptionMedicineController;
use App\Http\Controllers\RoleController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ReportRevenue;

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
    return view('index');
});


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/forgetPw', [ForgetPasswordController::class, 'getEmail'])->name('forgetPw');
Route::post('/forgetPw', [ForgetPasswordController::class, 'postEmail'])->name('forget-password');
Route::get('resetpw/{token}', [ForgetPasswordController::class, 'getPassword'])->name('resetPw');
Route::post('resetpw', [ForgetPasswordController::class, 'updatePassword'])->name('updatePw');

Route::middleware('adminLogin')->prefix('admin')->group(function () {

    Route::prefix('home')->group(function () {
        Route::get('/', [UserController::class, 'home'])->name('home.index');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:list_user');
        Route::get('/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:add_user');
        Route::post('/create', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:edit_user');
        Route::post('/{id}/edit', [UserController::class, 'update'])->name('user.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:delete_user');
        Route::get('/changepassword', [UserController::class, 'changepasswordform'])->name('user.changepasswordform');
        Route::post('/changepassword/{id}', [UserController::class, 'changepassword'])->name('user.changepassword');
        Route::get('/changeprofile', [UserController::class, 'changeprofileform'])->name('user.changeprofileform');
        Route::post('/changeprofile/{id}', [UserController::class, 'changeprofile'])->name('user.changeprofile');
    });

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:list_role');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:add_role');
        Route::post('/create', [RoleController::class, 'store'])->name('role.store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:edit_role');
        Route::post('/{id}/edit', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:delete_role');
    });

    Route::prefix('unit')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('unit.index')->middleware('permission:list_unit');
        Route::post('/create', [UnitController::class, 'store'])->name('unit.store')->middleware('permission:add_unit');
        Route::get('/{id}/edit', [UnitController::class, 'edit'])->name('unit.edit')->middleware('permission:edit_unit');
        Route::post('/{id}/edit', [UnitController::class, 'update'])->name('unit.update')->middleware('permission:edit_unit');
        Route::delete('/destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy')->middleware('permission:delete_unit');
    });
    Route::prefix('medicine')->group(function () {
        Route::get('{category?}', [MedController::class, 'index'])->name('med.index')->middleware('permission:list_med');
    });
    Route::prefix('med')->group(function () {
        Route::get('/create', [MedController::class, 'create'])->name('med.create')->middleware('permission:add_med');
        Route::post('/create', [MedController::class, 'store'])->name('med.store');
        Route::get('/{id}/edit', [MedController::class, 'edit'])->name('med.edit')->middleware('permission:edit_med');
        Route::post('/{id}/edit', [MedController::class, 'update'])->name('med.update');
        Route::delete('/destroy/{id}', [MedController::class, 'destroy'])->name('med.destroy')->middleware('permission:delete_med');
        Route::get('/almostOver', [MedController::class, 'almostOver'])->name('med.aboutToExpire')->middleware('permission:list_almostOver');
    });
    Route::prefix('lotsList')->group(function () {
        Route::get('{data?}', [LotsController::class, 'index'])->name('lots.index')->middleware('permission:list_lot');
    });
    Route::prefix('lots')->group(function () {
        Route::post('/searchDate', [LotsController::class, 'search'])->name('lots.search');
        Route::get('/create', [LotsController::class, 'create'])->name('lots.create')->middleware('permission:add_lot');
        Route::post('/create', [LotsController::class, 'store'])->name('lots.store');
        Route::get('/{id}/edit', [LotsController::class, 'edit'])->name('lots.edit')->middleware('permission:edit_lot');
        Route::post('/{id}/edit', [LotsController::class, 'update'])->name('lots.update');
        Route::delete('/destroy/{id}', [LotsController::class, 'destroy'])->name('lots.destroy')->middleware('permission:delete_lot');
    });


    Route::prefix('prescription')->group(function () {
        Route::get('', [PrescriptionController::class, 'index'])->name('prescription.index')->middleware('permission:list_prescription');
        Route::get('create', [PrescriptionController::class, 'create'])->name('prescription.create')->middleware('permission:add_prescription');
        Route::post('store', [PrescriptionController::class, 'store'])->name('prescription.store');
        Route::get('/{id}/delete', [PrescriptionController::class, 'deletePrescription'])->name('prescription.delete')->middleware('permission:delete_prescription');
        Route::get('print/{id}', [PrescriptionController::class, 'print'])->name('prescription.print')->middleware('permission:print_prescription');
        Route::get('exportWord/{id}', [PrescriptionController::class, 'exportWord'])->name('prescription.exportWord')->middleware('permission:word_prescription');
        Route::get('re-exam/{id}', [PrescriptionController::class, 'reExam'])->name('prescription.reExam');
        Route::post('re-exam/{id}', [PrescriptionController::class, 'storeExam'])->name('prescription.storeExam');
    });


    Route::prefix('report-revenue')->group(function () {
        Route::get('show', [ReportRevenue::class, 'show'])->name('report.show')->middleware('permission:report_revenue');
        Route::post('show-date-report', [ReportRevenue::class, 'dateReport'])->name('datereport.show');
    });



    Route::prefix('sympton')->group(function () {
        Route::get('', [SymptonController::class, 'index'])->name('sympton.index')->middleware('permission:list_symton');
        Route::post('add-sympton-ajax', [SymptonController::class, 'addSympton']);
        Route::post('/add-sympton', [SymptonController::class, 'store'])->name('sympton.store')->middleware('permission:add_symton');
        Route::get('/{id}/edit', [SymptonController::class, 'edit'])->middleware('permission:edit_symton');
        Route::post('/{id}/edit', [SymptonController::class, 'update']);
        Route::delete('/{id}/destroy', [SymptonController::class, 'destroy'])->name('sympton.destroy')->middleware('permission:delete_symton');
    });


    Route::prefix('prescription-medicine')->group(function () {
        Route::post('add-prescription-medicine', [PrescriptionMedicineController::class, 'addPrescriptionMedicine'])->name('addPrescriptionMedicine');
        Route::delete('delete-prescription-medicine/{id}', [PrescriptionMedicineController::class, 'delete'])->name('PrescriptionMedicine.delete');
    });



    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingAppController::class, 'index'])->name('setting.index')->middleware('permission:list_setting');
        Route::get('/create', [SettingAppController::class, 'create'])->name('setting.create')->middleware('permission:add_setting');
        Route::post('/create', [SettingAppController::class, 'store'])->name('setting.store');
        Route::get('/{id}/edit', [SettingAppController::class, 'edit'])->name('setting.edit')->middleware('permission:edit_setting');
        Route::post('/{id}/edit', [SettingAppController::class, 'update'])->name('setting.update');
        Route::get('/{id}/destroy', [SettingAppController::class, 'destroy'])->name('setting.destroy')->middleware('permission:delete_setting');
    });

    Route::prefix('medicine')->group(function () {
        Route::post('get-sell-price', [MedicineController::class, 'getSellPrice']);
    });

    Route::prefix('medCategory')->group(function () {
        Route::get('', [MedCategoryController::class, 'index'])->name('medCategory.index')->middleware('permission:list_medCategory');
        Route::post('/add-med-category', [MedCategoryController::class, 'store'])->name('medCategory.store')->middleware('permission:add_medCategory');
        Route::get('/{id}/edit', [MedCategoryController::class, 'edit'])->middleware('permission:edit_medCategory');
        Route::post('/{id}/edit', [MedCategoryController::class, 'update']);
        Route::delete('/{id}/destroy', [MedCategoryController::class, 'destroy'])->middleware('permission:delete_medCategory');
    });
});
