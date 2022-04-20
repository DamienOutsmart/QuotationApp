<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\Quotation;
use App\Models\quotationLines;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param integer $id
     * @return Response
     */

    //Clean this up and divide it in multiple controllers with Create, Update, Index, Show

    public function index(Quotation $quotation)
    {
        return $quotation->id;
    }

    public function store(Request $request)
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
        $quotation = Quotation::create($attributes);

        return ($quotation);
    }

    public function show(Request $request)
    {
        $user = User::find($request->id = 1);

        Auth::login($user);

        return Quotation::all();
    }

    public function previewQuotation($id)
    {
        $query = DB::table('quotations')
            ->join('quotationLines', 'quotation_id', '=', 'quotations.id')
            ->join('products', 'quotationlines.contents_id', '=', 'products.id')
            ->where('quotations.id', '=', $id)
            ->get();

        print 'previewQuotation';

        return $query;
    }

    public function calculate($id)
    {
        $queries = DB::table('products')
            ->join('quotation_lines', 'products.id', '=', 'contents_id')
            ->where('quotation_lines.quotation_id', '=', $id)
            ->select('quotation_lines.quotation_id', 'quotation_lines.amount', 'products.price')
            ->get();

        $sumArray = [];

        foreach ($queries as $query) {
            $sumPrice = ($query->price * $query->amount);
            $sumArray[] = $sumPrice;
        }

        $totalPrice = (array_sum($sumArray));

        return $totalPrice;
    }

    public function getLines($quotationId)
    {
        $quotation = Quotation::where('id', '=', $quotationId)
            ->with('quotationLines')
            ->first();

        return $quotation;
    }

    public function storeQuotationLines(Request $request)
    {
        $attributes = $request->validate([
            'amount'       => 'required',
            'quotation_id' => 'required',
            'contents_id'  => 'required',
        ]);

        $quotationLines = QuotationLines::create($attributes);

        return $quotationLines;
    }

    public function productIndex(product $product)
    {
        return product::all();
    }
}
