<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('api')->group(function (){

    //Working
    Route::get('usergetquotations/1', [QuotationController::class, 'show']);

    Route::get('quotationcalculatecost/{quotations:id}', [QuotationController::class, 'calculate']);

    Route::get('products', [QuotationController::class, 'productIndex']);

    Route::post('newquotationline/{quotations:id}', [QuotationController::class, 'storeQuotationLines']);

    //Work in Progress
    Route::post('quotationgetlines/{quotations:id}', [QuotationController::class, 'store']);
    Route::get('quotations/{quotationlines:quotation_id}', [QuotationController::class, 'index']);
    Route::get('quotationgetlines/{quotations:id}',[QuotationController::class, 'getLines']);
    Route::get('quotationpreview/{quotations:id}', [QuotationController::class, 'previewQuotation']);
});
