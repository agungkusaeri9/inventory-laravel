<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login', 301);

Auth::routes();

// admin
Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // roles
    Route::resource('roles', RoleController::class)->except('show');
    // permissions
    Route::resource('permissions', PermissionController::class)->except('show');

    // jenis
    Route::resource('jenis', JenisController::class)->except('show');

    // satuan
    Route::resource('satuan', SatuanController::class)->except('show');

    // supplier
    Route::resource('supplier', SupplierController::class)->except('show');

    // barang
    Route::resource('barang', BarangController::class)->except('show');
    Route::get('barang/get-by-id-json', [BarangController::class, 'getByIdJson'])->name('barang.getByIdJson');

    // barang-masuk
    Route::resource('barang-masuk', BarangMasukController::class)->except('show');
    // barang-keluar
    Route::resource('barang-keluar', BarangKeluarController::class)->except('show');
});
