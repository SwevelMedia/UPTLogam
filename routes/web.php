<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ToolsController;
use App\Http\Controllers\admin\ProsesController;
use App\Http\Controllers\client\orderController;
use App\Http\Controllers\admin\MachineController;
use App\Http\Controllers\Client\clientController;
use App\Http\Controllers\admin\karyawanController;
use App\Http\Controllers\admin\MaterialController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SubProsesController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\programmer\ProgOrderController;
use App\Http\Controllers\programmer\ToolsOrderController;
use App\Http\Controllers\operator\OperatorOrderController;
use App\Http\Controllers\machiner\MachinerMesinController;
use App\Http\Controllers\machiner\DashboardController as MachinerDashboardController;
use App\Http\Controllers\ppic\orderController as PpicOrderController;
use App\Http\Controllers\ppic\PrintController as PpicPrintController;
use App\Http\Controllers\admin\OrderController as adminOrderController;
use App\Http\Controllers\ppic\MachineController as PpicMachineController;
use App\Http\Controllers\ppic\DashboardController as PpicDashboardController;
use App\Http\Controllers\toolman\DashboardController as ToolmanDashboardController;
use App\Http\Controllers\operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\toolman\ToolsOrderController as ToolmanToolsOrderController;
use App\Http\Controllers\programmer\DashboardController as ProgrammerDashboardController;

use App\Http\Controllers\API\prosesController as APIprosesController;
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

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/API/desain/cam/{id}', [APIprosesController::class, 'dataCam']);


Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::post('/proses/action', [HomeController::class, 'procAction']);
    Route::get('/scan', [HomeController::class, 'halaman_scan']);
    Route::post('/scan/attempt', [HomeController::class, 'scan']);

    Route::get('/order/{id}', [HomeController::class, 'detail'])->name('order.detail');

    Route::get('/profile/{id}', [HomeController::class, 'profile'])->middleware('ProfileAccess');
    Route::post('/pp/update/{id}', [HomeController::class, 'ppUpdate'])->middleware('ProfileAccess');
    Route::post('/profile/update/{id}', [HomeController::class, 'profileUpdate'])->middleware('ProfileAccess');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('UserAccess:admin');
    Route::resource('/karyawan', karyawanController::class)->middleware('UserAccess:admin');
    Route::resource('/machine', MachineController::class)->middleware('UserAccess:admin');
    Route::post('/mesin/tambah-proses', [MachineController::class, 'tambahProses'])->middleware('UserAccess:admin');
    Route::post('/mesin/edit-proses/{id}', [MachineController::class, 'editProses'])->middleware('UserAccess:admin');
    Route::post('/mesin/tambah-subproses', [MachineController::class, 'tambahSubProses'])->middleware('UserAccess:admin');
    Route::post('/mesin/edit-subproses/{id}', [MachineController::class, 'editSubProses'])->middleware('UserAccess:admin');
    Route::post('/mesin/hapus-sub/{id}', [MachineController::class, 'hapusSub'])->middleware('UserAccess:admin');
    Route::post('/mesin/hapus-proses/{id}', [MachineController::class, 'hapusProses'])->middleware('UserAccess:admin');
    Route::resource('/tool', ToolsController::class)->middleware('UserAccessDouble:admin-toolman');
    Route::resource('/material', MaterialController::class)->middleware('UserAccessDouble:admin-ppic');
    Route::resource('/proses', ProsesController::class)->middleware('UserAccess:admin');
    Route::resource('/proses/subproses', SubProsesController::class)->middleware('UserAccess:admin');
    Route::get('/admin/order', [adminOrderController::class, 'index'])->middleware('UserAccess:admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/ppic/dashboard', [PpicDashboardController::class, 'index'])->name('ppic.dashboard')->middleware('UserAccess:ppic');
    Route::resource('/ppic/order', PpicOrderController::class)->middleware('UserAccess:ppic');
    Route::get('/order/jadwal/{id}', [PpicOrderController::class, 'jadwal'])->middleware('UserAccess:ppic')->name('order.jadwal');
    Route::post('/order/submit-jadwal', [PpicOrderController::class, 'submitJadwal'])->middleware('UserAccess:ppic');

    Route::get('/report/orderReport', [PpicOrderController::class, 'orderReport'])->middleware('UserAccessDouble:ppic-admin');
    Route::post('order/pilih-mesin/{id}', [PpicOrderController::class, 'pilihMesin'])->middleware('UserAccess:ppic');
    Route::post('order/pilih-mesin-accept/{id}', [PpicOrderController::class, 'pilihMesinAccept'])->middleware('UserAccess:ppic');
    Route::get('order/konfirmasi/{id}', [PpicOrderController::class, 'confirm'])->middleware('UserAccess:ppic')->name('order.confirm');
    Route::get('order/accept/{id}', [PpicOrderController::class, 'accept'])->middleware('UserAccess:ppic');
    Route::get('order/decline/{id}/{massage}', [PpicOrderController::class, 'decline'])->middleware('UserAccess:ppic');
    Route::post('/order/update-status', [PpicOrderController::class, 'updateStatus'])->name('order.updateStatus');

    Route::get('/order/{id}/print', [PpicPrintController::class, 'printPdf'])->name('order.pdf');
    Route::get('/order/{id}/report', [PpicPrintController::class, 'reportPdf'])->name('report.pdf');
    Route::get('/print-pdf/{id}', [PpicPrintController::class, 'printPdf'])->name('print.pdf');
    Route::get('/approve-desain/{id}', [PpicOrderController::class, 'approveDesain'])->middleware('UserAccess:ppic');
    Route::get('/approve-produksi/{id}', [PpicOrderController::class, 'approveProduksi'])->middleware('UserAccess:ppic');
    Route::post('/approve-produksi/{id}', [PpicOrderController::class, 'approveProduksiSubmit'])->middleware('UserAccess:ppic');
    Route::post('/approve-cad', [PpicOrderController::class, 'approveCad'])->middleware('UserAccess:ppic');
    Route::post('/approve-cad/back', [PpicOrderController::class, 'approveCadBack'])->middleware('UserAccess:ppic');
    Route::post('/revisi-cad', [PpicOrderController::class, 'revisiCad'])->middleware('UserAccess:ppic');
    Route::post('/order-decline', [PpicOrderController::class, 'orderDecline'])->middleware('UserAccess:ppic');
    Route::post('/approve-cad/back-decline', [PpicOrderController::class, 'approveCadBackDecline'])->middleware('UserAccess:ppic');
});

Route::middleware('auth')->group(function () {
    Route::get('/prog/dashboard', [ProgrammerDashboardController::class, 'index'])->name('prog.dashboard')->middleware('UserAccessDouble:programmer-drafter');
    Route::resource('/prog/tools', ToolsOrderController::class)->middleware('UserAccess:programmer');
    Route::post('/prog/tools/delete', [ToolsOrderController::class, 'deleteTools'])->middleware('UserAccess:programmer')->name('toolorder.delete');
    Route::get('/prog/order', [ProgOrderController::class, 'index'])->middleware('UserAccessDouble:programmer-drafter');
    Route::get('/prog/order/{id}', [ProgOrderController::class, 'detail'])->middleware('UserAccessDouble:programmer-drafter');
    Route::get('/prog/order-history/{id}', [ProgOrderController::class, 'history'])->middleware('UserAccessDouble:programmer-drafter');
    Route::post('/prog/start-cad', [ProgOrderController::class, 'startCad'])->middleware('UserAccessDouble:programmer-drafter');
    Route::post('/prog/upload-cad', [ProgOrderController::class, 'uploadCad'])->middleware('UserAccessDouble:programmer-drafter');
    Route::post('/prog/no-cad', [ProgOrderController::class, 'noCad'])->middleware('UserAccessDouble:programmer-drafter');
    Route::get('/desain/cam/{id}', [ProgOrderController::class, 'cam'])->middleware('UserAccessDouble:programmer-ppic');

    Route::post('/prog/start-cam', [ProgOrderController::class, 'startCam'])->middleware('UserAccess:programmer');
    Route::post('/cam/edit-subproses/{id}', [ProgOrderController::class, 'editProses'])->middleware('UserAccessDouble:programmer-ppic');
    Route::post('/cam/tambah-subproses/{id}', [ProgOrderController::class, 'tambahProses'])->middleware('UserAccessDouble:programmer-ppic');
    Route::post('/prog/upload-cam', [ProgOrderController::class, 'uploadCam'])->middleware('UserAccessDouble:programmer-ppic');
    Route::post('/cam/hapus-proses/{id}', [ProgOrderController::class, 'hapusProses'])->middleware('UserAccessDouble:programmer-ppic');

    Route::get('/prog/revisi/{id}', [ProgOrderController::class, 'revisi'])->middleware('UserAccessDouble:programmer-drafter');

    Route::post('/submit-revisi/{id}', [ProgOrderController::class, 'submitRevisi'])->middleware('UserAccessDouble:programmer-drafter');
});

Route::middleware('auth')->group(function () {
    Route::get('/toolman/dashboard', [ToolmanDashboardController::class, 'index'])->name('toolman.dashboard')->middleware('UserAccess:toolman');
    Route::resource('/toolman/tools', ToolmanToolsOrderController::class)->middleware('UserAccess:toolman');
    Route::get('/tool/order/{id}', [ToolmanToolsOrderController::class, 'detail'])->middleware('UserAccess:toolman');
    Route::post('/tool/start', [ToolmanToolsOrderController::class, 'start'])->middleware('UserAccess:toolman');
    Route::post('/tool/submit', [ToolmanToolsOrderController::class, 'submit'])->middleware('UserAccess:toolman');
});


Route::middleware('auth')->group(function () {
    Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard')->middleware('UserAccess:operator');
    Route::get('/operator/produksi', [OperatorOrderController::class, 'index'])->middleware('UserAccess:operator');
    Route::post('/operator/start', [OperatorOrderController::class, 'start'])->middleware('UserAccess:operator');
    Route::get('/operator/order/{id}', [OperatorOrderController::class, 'order'])->middleware('UserAccess:operator');
    Route::get('/operator/produksi/{id}', [OperatorOrderController::class, 'produksi'])->middleware('UserAccess:operator');
    Route::post('/proses-start', [OperatorOrderController::class, 'prosesStart'])->middleware('UserAccess:operator');
    Route::post('/spindle-stop-last', [OperatorOrderController::class, 'spindleStopLast'])->middleware('UserAccess:operator');
    Route::post('/waktu-mesin', [OperatorOrderController::class, 'waktuMesin'])->middleware('UserAccess:operator');
    Route::post('/proses-stop', [OperatorOrderController::class, 'prosesStop'])->middleware('UserAccess:operator');
    Route::post('produksi/update-nama-proses/{id}', [OperatorOrderController::class, 'updateNamaProses'])->middleware('UserAccess:operator');
    Route::post('/operator/tambah-setting', [OperatorOrderController::class, 'tambahSetting'])->middleware('UserAccess:operator');
    Route::post('/operator/tambah-proses', [OperatorOrderController::class, 'tambahProses'])->middleware('UserAccess:operator');
    Route::post('/produksi/hapus-proses', [OperatorOrderController::class, 'hapusProses'])->middleware('UserAccess:operator');
    Route::post('operator/produksi-selesai/{id}', [OperatorOrderController::class, 'produksiSelesai'])->middleware('UserAccess:operator');
});

Route::middleware('auth')->group(function () {
    Route::get('/machiner/dashboard', [MachinerDashboardController::class, 'index'])->name('machiner.dashboard')->middleware('UserAccess:machiner');
    Route::get('/machiner/mesin', [MachinerMesinController::class, 'mesin'])->name('machiner.konfigmesin')->middleware('UserAccess:machiner');
    Route::post('/status-mesin', [MachinerMesinController::class, 'statusMesin'])->name('status.mesin')->middleware('UserAccess:machiner');
    Route::get('/machiner/detail/{id}', [MachinerMesinController::class, 'detail'])->middleware('UserAccess:machiner');
});


require __DIR__ . '/auth.php';

// Route::get('/order', function () {
//     return view('client.order');
// });
Route::get('/order', [orderController::class, 'index']);
Route::match(['get', 'post'], '/cek-status', [orderController::class, 'cek_status'])->name('check.status');


Route::post('/autofill', 'AutofillController@autofill');

#Route Bagian Order Customers
Route::post('/client/order', [OrderController::class, 'order'])->name('client.order');
Route::get('/order-success', [OrderController::class, 'orderSuccess'])->name('client.success');
Route::post('/update-status', [OrderController::class, 'updateStatus'])->name('update-status');

#Route mesin
Route::get('/machines', [PpicMachineController::class, 'index']);
