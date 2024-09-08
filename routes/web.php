<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KBController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\KehamilanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PersalinanController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IbuBersalinController;
use App\Http\Controllers\ImunisasiLengkapController;
use App\Http\Controllers\JenisImunisasiController;
use App\Http\Controllers\KbLengkapController;
use App\Http\Controllers\KehamilanPersalinanController;
use App\Http\Controllers\ScoreboardKehamilanPersalinanController;
use App\Models\Persalinan;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['auth'])->group(function () {

Route::get('/home', [HomeController::class, 'index'])->name('home.index');


Route::get('/table', function () {
    return view('table');
});

//////////////////////////////OBAT//////////////////////////////////
Route::get('/obat', [ObatController::class, 'index']);
//import dan export excel ibu
Route::post('/import-excel-ibu', [IbuController::class, 'import']);
Route::get('/export-excel-ibu', [IbuController::class, 'export']);

//////////////////////////////IBU//////////////////////////////////
Route::get('/ibu', [IbuController::class, 'index'])->name('ibu.index');
//import dan export excel ibu
Route::post('/import-excel-ibu', [IbuController::class, 'import']);
Route::get('/export-excel-ibu', [IbuController::class, 'export']);

//////////////////////////////ANAK///////////////////////
Route::get('/anak', [AnakController::class, 'index'])->name('anak.index');
//import dan export excel anak
Route::post('/import-excel-anak', [AnakController::class, 'import']);
Route::get('/export-excel-anak', [AnakController::class, 'export']);

////////////////////////////Keluarga Berencana////////////////////////////
Route::get('/kb', [KBController::class, 'index'])->name('kb.index');
//import dan export excel kb
Route::post('/import-excel-kb', [KBController::class, 'import']);

/////////////////////////////IMUNISASI///////////////////////////////////
Route::get('/imunisasi', [ImunisasiController::class, 'index'])->name('imunisasi.index');
//import dan export excel imunisasi
Route::post('/import-excel-imunisasi', [ImunisasiController::class, 'import'])->name('imunisasi.import');
// Route::get('/export-excel-imunisasi', [KBController::class, 'export']);

/////////////////////////////KEHAMILAN///////////////////////////////////
Route::get('/kehamilan', [KehamilanController::class, 'index'])->name('kehamilan.index');
//import dan export excel kehamilan
Route::post('/import-excel-kehamilan', [KehamilanController::class, 'import'])->name('kehamilan.import');
// Route::get('/export-excel-imunisasi', [KBController::class, 'export']);

/////////////////////////////PERSALINAN///////////////////////////////////
Route::get('/persalinan', [PersalinanController::class, 'index'])->name('persalinan.index');
//import dan export excel persalinan
Route::post('/import-excel-persalinan', [PersalinanController::class, 'import'])->name('persalinan.import');
// Route::get('/export-excel-imunisasi', [KBController::class, 'export']);

Route::get('/charts', function () {
    return view('charts');
});

Route::get('/datauser', [DataUserController::class, 'index'])->name('datauser.index');
Route::post('/datauser/tambahuser', [DataUserController::class, 'tambah'])->name('datauser.tambah');
Route::delete('/datauser/deleteuser/{id}', [DataUserController::class, 'delete'])->name('datauser.delete');
Route::put('/datauser/updateuser/{id}', [DataUserController::class, 'update'])->name('datauser.update');

});

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout')->middleware('auth');

/////////////////////////////////////////////////MIA///////////////////////////////////////////////////////////////////
Route::get('/import-ibubersalin', [IbuBersalinController::class, 'importFromFile'])->name('nama.importFromFile');
Route::get('/ibu-bersalin', [IbuBersalinController::class, 'index'])->name('ibu_bersalin.index');

// Imunisasi Lengkap
Route::get('/import-imunisasilengkap', [ImunisasiLengkapController::class, 'importFromFile'])->name('imunisasilengkap.importFromFile');
Route::get('/import-jenisimunisasi', [ImunisasiLengkapController::class, 'importFromFileJenis'])->name('jenisimunisasi.importFromFile');
Route::get('/import-detailimunisasi', [ImunisasiLengkapController::class, 'importFromFileDetailJenis'])->name('detailjenisimunisasi.importFromFile');
Route::get('/imunisasi-lengkap', [ImunisasiLengkapController::class, 'index'])->name('imunisasi_lengkap.index');

// Kb Lengkap
Route::get('/import-kblengkap', [KbLengkapController::class, 'importFromFile'])->name('kblengkap.importFromFile');
Route::get('/kb-lengkap', [KbLengkapController::class, 'index'])->name('kb_lengkap.index');

// Kehamilan dan Persalinan
Route::get('/import-sbkehamilanpersalinan', [KehamilanPersalinanController::class, 'importFromFileScoreboard'])->name('kehamilanpersalinan.importFromFileScoreboard');
Route::get('/import-kunjunganbumil', [KehamilanPersalinanController::class, 'importFromFileKunjungan'])->name('kehamilanpersalinan.importFromFileKunjungan');
Route::get('/import-imunisasibumil', [KehamilanPersalinanController::class, 'importFromFileImunisasi'])->name('kehamilanpersalinan.importFromFileImunisasi');
Route::get('/import-lahiranbumil', [KehamilanPersalinanController::class, 'importFromFileLahiran'])->name('kehamilanpersalinan.importFromFileLahiran');
Route::get('/import-tabletbumil', [KehamilanPersalinanController::class, 'importFromFileTablet'])->name('kehamilanpersalinan.importFromFileTablet');
Route::get('/kehamilan-persalinan', [KehamilanPersalinanController::class, 'index'])->name('kehamilan_persalinan.index');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');