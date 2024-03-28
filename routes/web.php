<?php

use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\CustomerPanel\CustomerController;
use App\Http\Controllers\DealerPanel\DealerController;
use App\Http\Controllers\DealerPanel\DealerPurchasedVehicleController;
use App\Http\Controllers\DealerPanel\DealerPurchasesVehicleController;
use App\Http\Controllers\DealerPanel\DealerPurchaseVehicleController;
use App\Http\Controllers\DealerPanel\DealerVehicleController;
use App\Http\Controllers\ManufacturerPanel\ManufacturerController;
use App\Http\Controllers\ManufacturerPanel\ManufacturerInventoryController;
use App\Http\Controllers\ManufacturerPanel\ManufacturerSalesController;
use App\Http\Controllers\ManufacturerPanel\ManufacturerVehicleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManufacturerPanel\PurchaseModelPartController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SupplierPanel\InventorySalesController;
use App\Http\Controllers\SupplierPanel\ModelPartsController;
use App\Http\Controllers\SupplierPanel\SupplierController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PublicController::class, 'browseAllVehicles']);
Route::get('/featured-cars', [PublicController::class, 'featuredCars']);
Route::get('/featured-cars', [PublicController::class, 'featuredCars'])->name('featuredCars.search');
Route::get('/vehicles', [PublicController::class, 'Vehicles']);
Route::get('/vehicles/search', [PublicController::class, 'vehicles'])->name('vehicles.search');
Route::get('/find-dealer', [PublicController::class, 'findDealer']);



Route::get('/layout', [PublicController::class, 'layout']);

// Route::get('/', function () {
//     return view('customer/dashboard');
//     // return view('dashboard');
// });

Route::get('/dashboard', [CustomerController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::middleware(['auth', 'role:supplier'])->group(function () {
    Route::get('supplier/dashboard', [SupplierController::class, 'index'])->name('supplier.dashboard');
    Route::get('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
    Route::get('supplier/dashboard/modelparts', [ModelPartsController::class, 'index'])->name('supplier.modelparts.index');
    Route::get('supplier/dashboard/modelparts/search', [ModelPartsController::class, 'search'])->name('supplier.modelparts.search');
    Route::post('supplier/dashboard/modelparts', [ModelPartsController::class, 'store'])->name('supplier.modelparts.store');
    Route::put('/supplier/modelparts/{modelpart}', [ModelPartsController::class, 'update'])->name('supplier.modelparts.update');
    Route::delete('/supplier/modelparts/{id}', [ModelPartsController::class, 'destroy'])->name('supplier.modelparts.destroy');
    // Inventory sales route
    Route::get('supplier/dashboard/inventory-sales', [InventorySalesController::class, 'index'])->name('supplier.inventory_sales');
    Route::get('supplier/dashboard/inventory-sales/sort/{sort}', [InventorySalesController::class, 'index'])->name('supplier.inventory_sales.sort');
});


Route::middleware(['auth', 'role:manufacturer'])->group(function () {
    Route::get('manufacturer/dashboard', [ManufacturerController::class, 'index'])->name('manufacturer.dashboard');
    Route::get('/manufacturer/search', [ManufacturerController::class, 'search'])->name('manufacturer.search');
    // Route for purchasing a model part
    Route::post('/manufacturer/dashboard/purchase-model-part/{id}', [PurchaseModelPartController::class, 'purchase'])->name('manufacturer.purchase');
    Route::get('/manufacturer/dashboard/purchased-model-parts', [PurchaseModelPartController::class, 'purchasedModelParts'])->name('manufacturer.purchasedModelParts');
    Route::get('/manufacturer/modelparts/search', [PurchaseModelPartController::class, 'search'])->name('manufacturer.modelparts.search');

    // Route for manufacturer vehicles
    Route::post('/manufacturer/dashboard/vehicles', [ManufacturerVehicleController::class, 'store'])->name('manufacturer.storeVehicle');

    Route::get('/manufacturer/dashboard/vehicles', [ManufacturerVehicleController::class, 'index'])->name('manufacturer.vehicles.index');
    Route::get('/manufacturer/dashboard/vehicles/{id}/edit', [ManufacturerVehicleController::class, 'editVehicle'])->name('manufacturer.editVehicle');
    Route::put('/manufacturer/dashboard/vehicles/{id}', [ManufacturerVehicleController::class, 'updateVehicle'])->name('manufacturer.updateVehicle');
    Route::delete('/manufacturer/dashboard/vehicles/{id}', [ManufacturerVehicleController::class, 'destroy'])->name('manufacturer.destroyVehicle');


    Route::get('/manufacturer/dashboard/inventory', [ManufacturerInventoryController::class, 'index'])->name('manufacturer.inventory.index');
    Route::get('/manufacturer/dashboard/sales', [ManufacturerSalesController::class, 'index'])->name('manufacturer.sales.index');
    Route::get('/manufacturer/dashboard/sales/search', [ManufacturerSalesController::class, 'search'])->name('manufacturer.sales.search');
});


// Route::middleware(['auth','role:dealer'])->group(function () {
//     Route::get('dealer/dashboard', [DealerController::class, 'index'])->name('dealer.dashboard');
// }); 
Route::middleware(['auth', 'role:dealer'])->group(function () {
    Route::get('dealer/dashboard', [DealerController::class, 'index'])->name('dealer.dashboard');
    Route::get('dealer/dashboard/search', [DealerController::class, 'search'])->name('dealer.search');
    Route::post('/dealer/dashboard/purchase', [DealerController::class, 'purchase'])->name('dealer.purchase');
    Route::get('dealer/dashboard/car-inventory', [DealerController::class, 'carInventory'])->name('dealer.carInventory');
    Route::get('dealer/dashboard/purchased-vehicles', [DealerController::class, 'purchasedVehicles'])->name('dealer.purchasedVehicles');
    Route::get('dealer/dashboard/purchased-vehicles/search', [DealerController::class, 'purchasedVehiclesSearch'])->name('dealer.purchasedVehicles.search');
    Route::get('dealer/dashboard/car-inventory/{id}/edit', [DealerController::class, 'edit'])->name('dealer.vehicles.edit');
    Route::get('dealer/dashboard/car-inventory/search', [DealerController::class, 'carInventorySearch'])->name('dealer.car-inventory.search');

});
