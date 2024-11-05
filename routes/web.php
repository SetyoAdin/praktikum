<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\TanggalController;
use App\Http\Controllers\UjadwalController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
//ROUTE GET
Route::get('/datajadwal', [JadwalController::class, 'datajadwal'])->name('datajadwal');
Route::get('/datatanggal', [TanggalController::class, 'datatanggal'])->name('datatanggal');
Route::get('/matkul', [MatakuliahController::class, 'matkul'])->name('matkul')->middleware('auth');
Route::get('/form', [MahasiswaController::class, 'form'])->name('form');
Route::get('/sidebar', [JadwalController::class, 'sidebar'])->name('sidebar');
Route::get('/halaman', [MahasiswaController::class, 'halaman'])->name('halaman');
Route::get('/viewjw', [JadwalController::class, 'viewjw'])->name('viewjw');
Route::get('/dash', [MahasiswaController::class, 'dash'])->name('dash');
Route::get('/transfer-data-page', [UjadwalController::class, 'showTransferPage']);
Route::get('/ummadmin', [LoginController::class, 'loginadmin'])->name('ummadmin');
Route::get('/role', [AuthController::class, 'role'])->name('role');
Route::get('/mahasiswa', [MahasiswaController::class, 'mahasiswa'])->name('mahasiswa')->middleware('auth');
Route::get('/min', [MahasiswaController::class, 'min'])->name('min');
Route::get('/panel', [MahasiswaController::class, 'panel'])->name('panel');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/registeradmin', [AuthController::class, 'registeradmin'])->name('registeradmin')->middleware('role:super');
Route::get('/get-emails', [AuthController::class, 'getEmails'])->middleware('auth');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
//AJAXX
Route::get('/get-tanggal/{matkulId}', [JadwalController::class, 'getTanggal']);
Route::get('/get-sesi/{tanggalId}', [JadwalController::class, 'getSesi']);
Route::get('/get-jadwal-detail/{jadwalId}', [JadwalController::class, 'getJadwalDetail']);
Route::put('/mata-kuliah/{id}', [MataKuliahController::class, 'update']);
Route::put('/updatetanggal/{id}', [TanggalController::class, 'updateTanggal'])->name('updatetanggal');
Route::put('/user/update/{id}', [AuthController::class, 'updateNama'])->name('user.update');
//MIDELWARE(ADMIN)



//ROUTE POST
Route::post('/tambahtanggal', [TanggalController::class, 'tambahtanggal'])->name('tambahtanggal');
Route::post('/insertjw', [JadwalController::class, 'insertjw'])->name('insertjw');
Route::post('/insertmatkul', [MatakuliahController::class, 'insertmatkul'])->name('insertmatkul');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/insertmatkul', [MatakuliahController::class, 'insertMatkul'])->name('insertmatkul');
Route::post('/inserttanggal', [MatakuliahController::class, 'insertTanggal'])->name('inserttanggal');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/insertmhs', [MahasiswaController::class, 'insertmhs'])->name('insertmhs');
Route::post('/insertkelas', [KelasController::class, 'store'])->name('insertkelas');
Route::post('/reset-password/{email}', [AuthController::class, 'updatePassword'])->middleware('auth');
Route::post('/user/update-name', 'AuthController@updateName');
Route::post('/update-username', [AuthController::class, 'updateUsername'])->name('update.username');

//ROUTE DELETE
Route::delete('/delmatkul/{id}', [MatakuliahController::class, 'deleteMatkul'])->name('delmatkul');
Route::delete('/user/{id}', [AuthController::class, 'deleteUser'])->name('user.delete');
Route::delete('/hapus/{id_tanggal}', [TanggalController::class, 'hapusData'])->name('hapustgl');
Route::delete('/tanggal/{id}', [TanggalController::class, 'destroy'])->name('tanggal.destroy');
Route::delete('/auth/{id}', [AuthController::class, 'destroy'])->name('auth.destroy');
Route::delete('/jadwal/{id_tanggal}', [JadwalController::class, 'confirmDelete'])->name('jadwal.delete');
Route::delete('/tanggal/{id}', [TanggalController::class, 'destroy'])
    ->name('tanggal.destroy');
