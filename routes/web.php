<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcrylicStockController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/export-produksi-excel', [DashboardController::class, 'exportProduksiExcel'])
        ->name('dashboard.exportProduksiExcel');

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //================== LOGOUT =================
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');


    // ================= ORDER =================
    Route::resource('orders', OrderController::class);

    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('orders/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('orders.invoice.download');

    // ================= ACRYLIC STOCK =================
    Route::resource('acrylic-stocks', AcrylicStockController::class);

    // ================= INVENTORY =================
    Route::resource('inventories', InventoryController::class);
    Route::post('/inventories/{id}/update-stock', [InventoryController::class, 'updateStock'])
        ->name('inventories.updateStock');

    // ================= PRODUCTION =================
    Route::resource('productions', ProductionController::class)
        ->only(['index', 'show', 'edit', 'update']);

    // ================= DELIVERY / SURAT JALAN =================
    Route::resource('delivery', DeliveryNoteController::class)
        ->only(['index', 'show', 'edit', 'update']);

    // ================= PICKUP =================
    Route::resource('pickup', PickupController::class)
        ->only(['index', 'show', 'edit', 'update']);

    // ================= DESIGN =================
    Route::resource('designs', DesignController::class)
        ->only(['index', 'show', 'edit', 'update']);
});

require __DIR__.'/auth.php';
