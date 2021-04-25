<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StockController extends Controller
{
    public function index()
    {


        $ultimosLancamentos = DB::table('stocks')
            ->select('register_product_id', 'quantity', DB::raw('MAX(reference_date) as reference_date'))
            ->groupBy('register_product_id');

        $dataStocks = DB::table('register_products')
            ->joinSub($ultimosLancamentos, 'stocks', function ($join) {
                $join->on('stocks.register_product_id', '=', 'register_products.id');
            })->get();
        return Inertia::render('Stocks/Index', [
            'dataStocks' => $dataStocks
        ]);
    }
}
