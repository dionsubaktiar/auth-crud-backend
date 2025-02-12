<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\TraditionalAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IMSController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\UnitController;

Route::post('/register', [TraditionalAuthController::class, 'register']);
Route::post('/login', [TraditionalAuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/me', [TraditionalAuthController::class, 'me']);
Route::middleware('auth:sanctum')->post('/logout', [TraditionalAuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', function () {
    return 'Welcome Home!';
})->middleware('auth');

Route::prefix('auth/{provider}')->group(function () {
    Route::get('/redirect', [SocialiteController::class, 'redirectToProvider']);
    Route::get('/callback', [SocialiteController::class, 'handleProviderCallback']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('article', DataController::class);
});

Route::apiResource('ims', IMSController::class);

Route::post('/bcaregister', [KonsumenController::class, 'register']);
Route::post('/bcalogin', [KonsumenController::class, 'login']);
Route::middleware('auth:sanctum')->get('/bcame', [KonsumenController::class, 'me']);
Route::middleware('auth:sanctum')->post('/bcalogout', [KonsumenController::class, 'logout']);

Route::resource('konsumen', KonsumenController::class);
Route::resource('kendaraan', KendaraanController::class);
Route::resource('pinjaman', PinjamanController::class);

Route::resource('customer', CustomerController::class);
Route::get('getcustomer', [CustomerController::class, 'getAll']);
Route::resource('unit', UnitController::class);
Route::get('getunit', [UnitController::class, 'getAll']);
Route::resource('part', PartController::class);
Route::get('getparts', [PartController::class, 'getAll']);
Route::resource('invoice', InvoiceController::class);
Route::resource('packages', PackageController::class);
Route::put('/invoice/{id}/accept-spk', [InvoiceController::class, 'accept_status_spk']);
Route::put('/invoice/{id}/cancel', [InvoiceController::class, 'cancel_status']);
Route::put('/invoice/{id}/spk-done', [InvoiceController::class, 'set_spk_done']);
Route::put('/invoice/{id}/invoice-clear', [InvoiceController::class, 'set_invoice_clear']);
