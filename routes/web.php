<?php

use App\Http\Controllers\BranchCompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderDetailController;
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

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');


Route::prefix('items')->name('items.')->group(function(){

    Route::get('/',[ItemsController::class, 'index'])->name('index');
    Route::get('/create',[ItemsController::class, 'create'])->name('create');
    Route::post('/create',[ItemsController::class, 'store'])->name('store');
});

// Purchase Order Routes
Route::prefix('purchase-order')->middleware(['auth'])->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase-order.index');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
    Route::get('/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('purchase-order.edit');
    Route::put('/update/{id}', [PurchaseOrderController::class, 'update'])->name('purchase-order.update');
    Route::delete('/destroy/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');
    Route::post('/submit/{id}', [PurchaseOrderController::class, 'submit'])->name('purchase-order.submit');
});

// Purchase Order Detail Routes
Route::prefix('purchase-order-detail')->middleware(['auth'])->group(function () {
    Route::get('/', [PurchaseOrderDetailController::class, 'index'])->name('purchase-order-detail.index');
    Route::post('/create', [PurchaseOrderDetailController::class, 'create'])->name('purchase-order-detail.create');
    Route::put('/update/{id}', [PurchaseOrderDetailController::class, 'update'])->name('purchase-order-detail.update');
    Route::delete('/destroy/{id}', [PurchaseOrderDetailController::class, 'destroy'])->name('purchase-order-detail.destroy');

    // AJAX Routes
    Route::post('/update-qty', [PurchaseOrderDetailController::class, 'updateQty'])->name('purchase-order-detail.updateQty');
    Route::post('/update-discount', [PurchaseOrderDetailController::class, 'updateDiscount'])->name('purchase-order-detail.updateDiscount');
});


Route::prefix('branch-company')->name('branch-company.')->group(function(){
    Route::get('/',[BranchCompanyController::class, 'index'])->name('index');
});


