<?php

use App\Http\Controllers\QuotationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Functioning
Route::get('quotations/{id}', [QuotationController::class, 'show']);
Route::post('quotations', [QuotationController::class, 'store']);
Route::get('quotationgetlines/{id}', [QuotationController::class, 'getLines']);
Route::post('quotationlines', [QuotationController::class, 'storeQuotationLines']);

Route::get('quotations', [QuotationController::class, 'index']);
Route::get('products', [QuotationController::class, 'index']);

//Work in progress
Route::get('quotationcalculatecost/{id}', [QuotationController::class, 'calculateTotalPrice']);
Route::get('quotationpreview/{id}', [QuotationController::class, 'previewQuotation']);

Route::get('newquotationline', [QuotationController::class, 'storeQuotationLines']);
Route::post('newquotationline', [QuotationController::class, 'storeQuotationLines']);
