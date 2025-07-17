<?php

use Illuminate\Support\Facades\Route;
use Modules\Goods\Http\Controllers\Backend\GoodsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin', 'as' => 'backend.'], function () {
    /*
     *
     *  Goods Management
     *
     * ---------------------------------------------------------------------
     */
    Route::group(['prefix' => 'goods', 'as' => 'goods.'], function () {
        Route::get('/', [GoodsController::class, 'index'])->name('index');
        Route::get('/index_data', [GoodsController::class, 'index_data'])->name('index_data');
        Route::get('/create', [GoodsController::class, 'create'])->name('create');
        Route::post('/', [GoodsController::class, 'store'])->name('store');
        Route::get('/{id}', [GoodsController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GoodsController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [GoodsController::class, 'update'])->name('update');
        Route::delete('/{id}', [GoodsController::class, 'destroy'])->name('destroy');
        
        // Inventory Moves Routes
        Route::get('/{id}/inventory-moves/create', [GoodsController::class, 'createInventoryMove'])->name('createInventoryMove');
        Route::post('/{id}/inventory-moves', [GoodsController::class, 'storeInventoryMove'])->name('storeInventoryMove');
        
        // Adjustments Routes
        Route::get('/{id}/adjustments/create', [GoodsController::class, 'createAdjustment'])->name('createAdjustment');
        Route::post('/{id}/adjustments', [GoodsController::class, 'storeAdjustment'])->name('storeAdjustment');
    });
});
