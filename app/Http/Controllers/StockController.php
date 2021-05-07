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


        $codStocks = DB::table('stocks')
            ->select('register_product_id', 'quantity', DB::raw('MAX(reference_date) as reference_date'))
            ->where('quantity', '>', 0)
            ->groupBy('register_product_id')
            ->get();

        $result = array();

        foreach ($codStocks as $row) {
            $row = (object) $row;

            $result[] = DB::table('stocks')
                ->where('register_product_id', '=', $row->register_product_id)
                ->where('reference_date', '=', $row->reference_date)
                ->join('register_products', 'register_products.id', '=', 'stocks.register_product_id')
                ->select('stocks.*', 'register_products.description', 'register_products.size', 'register_products.image_path')
                ->first();
        }

        return Inertia::render('Stocks/Index', [
            'dataStocks' => $result
        ]);
    }
}
