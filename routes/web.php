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

    if (auth()->check()) {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('dashboard'),
            'tim_desain' => redirect()->route('designs.index'),
            'tim_produksi' => redirect()->route('productions.index'),
            'driver' => redirect()->route('delivery.index'),
            'logistik' => redirect()->route('acrylic-stocks.index'),
            default => redirect()->route('login'),
        };
    }

    return redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/dashboard/export-produksi-excel', [DashboardController::class, 'exportProduksiExcel'])
            ->name('dashboard.exportProduksiExcel');

        // Orders
        Route::resource('orders', OrderController::class);

        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])
            ->name('orders.invoice');

        Route::get('orders/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])
            ->name('orders.invoice.download');
    });

    /*
    |--------------------------------------------------------------------------
    | ACRYLIC STOCKS (Admin + Logistik)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,logistik')->group(function () {
        Route::resource('acrylic-stocks', AcrylicStockController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | INVENTORY (Admin + Logistik)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,logistik')->group(function () {
        Route::resource('inventories', InventoryController::class);

        Route::post('/inventories/{id}/update-stock', [InventoryController::class, 'updateStock'])
            ->name('inventories.updateStock');
    });

    /*
    |--------------------------------------------------------------------------
    | PRODUCTION (Admin + Tim Produksi)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,tim_produksi')->group(function () {
        Route::resource('productions', ProductionController::class)
            ->only(['index', 'show', 'edit', 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | DELIVERY (Admin + Driver)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,driver')->group(function () {
        Route::resource('delivery', DeliveryNoteController::class)
            ->only(['index', 'show', 'edit', 'update']);

        Route::get('/delivery/{delivery}/surat-jalan-preview',
            [DeliveryNoteController::class, 'previewSuratJalan']
        )->name('delivery.suratjln.preview');

        Route::get('delivery/{delivery}/surat-jalan',
            [DeliveryNoteController::class, 'suratJalan']
        )->name('delivery.suratjln');
    });

    /*
    |--------------------------------------------------------------------------
    | PICKUP (Admin + Driver + Logistik)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,driver,logistik')->group(function () {
        Route::resource('pickup', PickupController::class)
            ->only(['index', 'show', 'edit', 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | DESIGN (Admin + Tim Desain)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,tim_desain')->group(function () {
        Route::resource('designs', DesignController::class)
            ->only(['index', 'show', 'edit', 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE (Semua Role)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__.'/auth.php';