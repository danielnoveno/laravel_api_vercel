<?php

use App\Http\Controllers\AlatGymController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisMembershipController;
use App\Http\Controllers\KelasOlahragaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PersonalTrainerController;
use App\Http\Controllers\ReviewTrainerController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TransaksiController;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [PelangganController::class, 'register']);
Route::post('/login', [PelangganController::class, 'login']);
Route::post('/logout', [PelangganController::class, 'logout'])->middleware('auth:sanctum');

Route::resource('alat_gym', AlatGymController::class);
Route::resource('coach', CoachController::class);
Route::resource('detail_transaksi', DetailTransaksiController::class);
Route::resource('jadwal', JadwalController::class);
Route::resource('jenis_membership', JenisMembershipController::class);
Route::resource('kelas_olahraga', KelasOlahragaController::class);
Route::resource('layanan', LayananController::class);
Route::resource('membership', MembershipController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('personal_trainer', PersonalTrainerController::class);
Route::resource('review', ReviewTrainerController::class);
Route::resource('riwayat', RiwayatController::class);
Route::resource('ruangan', RuanganController::class);
Route::resource('trainer', TrainerController::class);
Route::resource('transaksi', TransaksiController::class);

Route::get('/getImageUrl/{imageName}', [MembershipController::class, 'getImageUrl']);


Route::get('image', [MembershipController::class, "getImageUrl"]);