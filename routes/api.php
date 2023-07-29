<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KaryawanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::group(["middleware" => "jwt.verify"], function ($api) {
    Route::get("/karyawan", [KaryawanController::class, "index"]);
    Route::get("/karyawan/{id}", [KaryawanController::class, "show"]);
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get("/get-user-by-token", [AuthController::class, "me"]);
    Route::get("/refresh-token", [AuthController::class, "refreshToken"]);
    Route::put("/update-user/{id}", [AuthController::class, "updateUser"]);
    Route::delete("/delete-user/{id}", [AuthController::class, "deleteUser"]);
    Route::resource("absensi", AbsensiController::class);
});

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::get("/laporan-kehadiran/{user_id}", [AbsensiController::class, "getLaporanKehadiran"]);