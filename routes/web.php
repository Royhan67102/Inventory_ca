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

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= ORDER =================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
        Route::get('{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('invoice.download');
        Route::resource('/', OrderController::class)->parameters(['' => 'order']);
        Route::resource('orders', OrderController::class);

    });

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

    Route::resource('pickups', PickupController::class)
    ->only(['index', 'edit', 'update', 'destroy']);

});

require __DIR__.'/auth.php';
