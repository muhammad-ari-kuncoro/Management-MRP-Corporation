<?php

use App\Http\Controllers\BillsOfMaterialsController;
use App\Http\Controllers\BranchCompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderDetailController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WorkOrdersController;
use App\Models\PurchaseOrder;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');


Route::prefix('items')->name('items.')->middleware(['auth'])->group(function(){

    Route::get('/',[ItemsController::class, 'index'])->name('index');
    Route::get('/create',[ItemsController::class, 'create'])->name('create');
    Route::post('/create',[ItemsController::class, 'store'])->name('store');
    Route::get('/items/edit/{id}',[ItemsController::class, 'edit'])->name('edit');
    Route::put('/update-items/edit/{id}',[ItemsController::class, 'update'])->name('update');
});

// Purchase Order Routes
Route::prefix('purchase-order')->middleware(['auth'])->middleware(['auth'])->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase-order.index');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
    Route::get('/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('purchase-order.edit');
    Route::put('/update/{id}', [PurchaseOrderController::class, 'update'])->name('purchase-order.update');
    Route::delete('/destroy/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');
    Route::post('/submit/{id}', [PurchaseOrderController::class, 'submit'])->name('purchase-order.submit');
});

// Purchase Order Detail Routes
Route::prefix('purchase-order-detail')->middleware(['auth'])->middleware(['auth'])->group(function () {
    Route::get('/', [PurchaseOrderDetailController::class, 'index'])->name('purchase-order-detail.index');
    Route::post('/create', [PurchaseOrderDetailController::class, 'create'])->name('purchase-order-detail.create');
    Route::put('/update/{id}', [PurchaseOrderDetailController::class, 'update'])->name('purchase-order-detail.update');
    Route::delete('/destroy/{id}', [PurchaseOrderDetailController::class, 'destroy'])->name('purchase-order-detail.destroy');

    // AJAX Routes
    Route::post('/update-qty', [PurchaseOrderDetailController::class, 'updateQty'])->name('purchase-order-detail.updateQty');
    Route::post('/update-discount', [PurchaseOrderDetailController::class, 'updateDiscount'])->name('purchase-order-detail.updateDiscount');
});


Route::prefix('branch-company')->name('branch-company.')->middleware(['auth'])->group(function(){
    Route::get('/',[BranchCompanyController::class, 'index'])->name('index');
    Route::post('/create',[BranchCompanyController::class, 'store'])->name('store');
    Route::get('/branch-company/edit/{id}',[BranchCompanyController::class, 'edit'])->name('edit');
    Route::put('/update-branch/{id}',[BranchCompanyController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}',[BranchCompanyController::class, 'destroyData'])->name('destroy');
});


Route::prefix('supplier-company')->name('supplier-company.')->middleware(['auth'])->group(function(){
    Route::get('/',[SupplierController::class, 'index'])->name('index');
    Route::get('/create',[SupplierController::class, 'create'])->name('create');
    Route::post('/store',[SupplierController::class, 'store'])->name('store');
    Route::get('/supplier-company/edit/{id}',[SupplierController::class, 'edit'])->name('edit');
    Route::put('/update-supplier/{id}',[SupplierController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}',[SupplierController::class, 'destroy'])->name('destroy');
});

Route::prefix('bills-of-materials')->name('bills-of-materials.')->middleware(['auth'])->group(function () {
        Route::get('/', [BillsOfMaterialsController::class, 'index'])->name('index');
        Route::get('/create', [BillsOfMaterialsController::class, 'create'])->name('create');
        Route::post('/store', [BillsOfMaterialsController::class, 'store'])->name('store');
        Route::post('/store-detail', [BillsOfMaterialsController::class, 'storeDetailBOM'])->name('store-detail');
        Route::delete('/destroy/{id}', [BillsOfMaterialsController::class, 'destroy'])->name('bills-of-materials.destroy');
    });


Route::prefix('product')->name('product.')->group(function(){
    Route::get('/',[ProductController::class, 'index'])->name('index');
    Route::get('/create',[ProductController::class, 'create'])->name('create');
    Route::post('/store',[ProductController::class, 'store'])->name('store');
});

Route::prefix('work-orders')->name('work-orders.')->group(function(){
    Route::get('/',[WorkOrdersController::class, 'index'])->name('index');
    Route::get('/create',[WorkOrdersController::class, 'create'])->name('create');
    Route::post('/store',[WorkOrdersController::class, 'store'])->name('store');
});


