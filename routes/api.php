<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RekapAbsenMhs;
use App\Http\Controllers\Api\AbsenAjarController;
// use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\Mhs\LoginmhsController;


Route::get('/absen-ajars', [AbsenAjarController::class, 'index']);
Route::get('/absen-ajar-praktek', [AbsenAjarController::class, 'ajar_praktek']);
Route::get('/jadwal-dosen', [AbsenAjarController::class, 'jadwal']);


//group route with prefix "admin"
Route::prefix('admin')->group(function () {
    // Route::get('/master-soal', [UjianController::class, 'index'])->name('master-soal');
    //route login
    Route::post('/login-dosen', [App\Http\Controllers\Api\Admin\LoginController::class, 'index']);

    //group route with middleware "auth:api_admin"
    Route::group(['middleware' => 'auth:api_admin'], function () {

        //data user
        Route::get('/user', [App\Http\Controllers\Api\Admin\LoginController::class, 'getUser', ['as' => 'admin']]);

        //refresh token JWT
        Route::get('/refresh', [App\Http\Controllers\Api\Admin\LoginController::class, 'refreshToken', ['as' => 'admin']]);

        //logout
        Route::post('/logout', [App\Http\Controllers\Api\Admin\LoginController::class, 'logout', ['as' => 'admin']]);
    });
});

Route::prefix('mahasiswa')->group(function () {
    Route::post('/login-mhs', [LoginmhsController::class, 'index'])->name('customer.login');

    Route::middleware('auth:api_mhs')->group(function () {
        Route::get('/user', [LoginmhsController::class, 'getUser'])->name('customer.user');
        Route::get('/refresh', [LoginmhsController::class, 'refreshToken'])->name('customer.refresh');
        Route::post('/logout', [LoginmhsController::class, 'logout'])->name('customer.logout');
    });
});
