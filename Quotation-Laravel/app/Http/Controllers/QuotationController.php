<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\quotationLines;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index()
    {
        return Quotation::all();
    }

    public function store(Request $request): Quotation
    {
        $attributes = $request->validate([
            'id',
            'customer_city'         => 'required',
            'customer_email'        => 'required',
            'customer_first_name'   => 'required',
            'customer_house_number' => 'required',
            'customer_last_name'    => 'required',
            'customer_postal_code'  => 'required',
            'customer_street'       => 'required',
            'status'                => 'required',
        ]);

        $attributes['user_id'] = 1;

        return Quotation::create($attributes);
    }

    public function show(Quotation $quotation): Quotation
    {
        return $quotation->with('quotation_lines');
    }

    public function previewQuotation($quotationId)
    {
        $query = DB::table('quotations')
            ->join('quotationLines', 'quotation_id', '=', 'quotations.id')
            ->join('products', 'quotationlines.contents_id', '=', 'products.id')
            ->where('quotations.id', '=', $quotationId)
            ->get();

        print 'previewQuotation';

        return $query;
    }

    public function calculateTotalPrice($quotationId)
    {
        $products = DB::table('products')
            ->join('quotation_lines', 'products.id', '=', 'contents_id')
            ->where('quotation_lines.quotation_id', '=', $quotationId)
            ->select('quotation_lines.quotation_id', 'quotation_lines.amount', 'products.price')
            ->get();

        $sumArray = [];

        foreach ($products as $product) {
            $sumPrice = ($product->price * $product->amount);
            $sumArray[] = $sumPrice;
        }

        return array_sum($sumArray);
    }

    public function getLines($quotationId)
    {
        return Quotation::where('id', '=', $quotationId)
            ->with('quotationLines')
            ->first();
    }

    public function storeQuotationLines(Request $request)
    {
        $attributes = $request->validate([
            'amount'       => 'required',
            'quotation_id' => 'required',
            'contents_id'  => 'required',
        ]);

        return QuotationLines::create($attributes);
    }

    public function productIndex(product $product)
    {
        return Product::all();
    }
}
