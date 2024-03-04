<?php

use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\CustomerPanel\CustomerController;
use App\Http\Controllers\DealerPanel\DealerController;
use App\Http\Controllers\ManufacturerPanel\ManufacturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManufacturerPanel\PurchaseModelPartController;
use App\Http\Controllers\SupplierPanel\InventoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[CustomerController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});  

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function () {
Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::middleware(['auth','role:supplier'])->group(function () {
    Route::get('supplier/dashboard', [SupplierController::class, 'index'])->name('supplier.dashboard');
    Route::get('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
    Route::get('supplier/dashboard/modelparts', [ModelPartsController::class, 'index'])->name('supplier.modelparts.index');
    Route::get('supplier/dashboard/modelparts/search', [ModelPartsController::class, 'search'])->name('supplier.modelparts.search');  
    Route::post('supplier/dashboard/modelparts', [ModelPartsController::class, 'store'])->name('supplier.modelparts.store');
    Route::put('/supplier/modelparts/{modelpart}', [ModelPartsController::class, 'update'])->name('supplier.modelparts.update');
    Route::delete('/supplier/modelparts/{id}', [ModelPartsController::class, 'destroy'])->name('supplier.modelparts.destroy');

    //  route for the Parts Inventory
    Route::get('supplier/dashboard/inventory', [InventoryController::class, 'index'])->name('supplier.inventory');
    // Route::get('supplier/dashboard/inventory', [InventoryController::class, 'index'])->name('supplier.inventory');
});


Route::middleware(['auth','role:manufacturer'])->group(function () {
    Route::get('manufacturer/dashboard', [ManufacturerController::class, 'index'])->name('manufacturer.dashboard');
    Route::get('/manufacturer/search', [ManufacturerController::class, 'search'])->name('manufacturer.search');
    // Route for purchasing a model part
    Route::post('/manufacturer/dashboard/purchase-model-part/{id}', [PurchaseModelPartController::class, 'purchase'])->name('manufacturer.purchase');
    Route::get('/manufacturer/dashboard/purchased-model-parts', [PurchaseModelPartController::class, 'purchasedModelParts'])->name('manufacturer.purchasedModelParts');
    Route::get('/manufacturer/modelparts/search', [PurchaseModelPartController::class, 'search'])->name('manufacturer.modelparts.search');
});


Route::middleware(['auth','role:dealer'])->group(function () {
    Route::get('dealer/dashboard', [DealerController::class, 'index'])->name('dealer.dashboard');
});





