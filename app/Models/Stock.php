<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;




    public function incrementStock($order, $item)
    {

        $stockProduct = Stock::where('register_product_id', $item->register_product_id)
            ->where('reference_date', $order->request_date)
            ->first();

        if (is_null($stockProduct)) {
            $stockProduct = new Stock();

            $dataStock = Stock::select('quantity')
                ->where('register_product_id', '=', $item->register_product_id)
                ->where('reference_date', '<', $order->request_date)
                ->orderByDesc('reference_date')
                ->first();

            $stockProduct->quantity = (!is_null($dataStock) ? $dataStock->quantity : 0);
        }

        $stockProduct->register_product_id = $item->register_product_id;
        $stockProduct->quantity += $item->quantity;
        $stockProduct->reference_date = $order->request_date;

        $stockProduct->save();

        $this->reprocessPeriodsIncrement($order, $item);
    }

    public function decrementStock($order, $item)
    {

        $stockProduct = Stock::where('register_product_id', $item->register_product_id)
            ->where('reference_date', $order->request_date)
            ->first();

        if (is_null($stockProduct)) {
            $stockProduct = new Stock();

            $dataStock = Stock::select('quantity')
                ->where('register_product_id', '=', $item->register_product_id)
                ->where('reference_date', '<', $order->request_date)
                ->orderByDesc('reference_date')
                ->first();

            $stockProduct->quantity = (!is_null($dataStock) ? $dataStock->quantity : 0);
        }

        $stockProduct->register_product_id = $item->register_product_id;
        $stockProduct->quantity -= $item->quantity;
        $stockProduct->reference_date = $order->request_date;

        $stockProduct->save();

        $this->reprocessPeriodsDecrement($order, $item);
    }



    public function reprocessPeriodsIncrement($order, $item)
    {

        $getStocks = Stock::select('*')
            ->where('register_product_id', '=', $item->register_product_id)
            ->where('reference_date', '>', $order->request_date)
            ->get();

        foreach ($getStocks as $rowStock) {

            $stock = Stock::select('*')
                ->where('register_product_id', '=', $rowStock->register_product_id)
                ->where('reference_date', '=', $rowStock->reference_date)
                ->first();

            $stock->quantity += $item->quantity;

            $stock->save();
        }
    }


    public function reprocessPeriodsDecrement($order, $item)
    {

        $getStocks = Stock::select('*')
            ->where('register_product_id', '=', $item->register_product_id)
            ->where('reference_date', '>', $order->request_date)
            ->get();

        foreach ($getStocks as $rowStock) {

            $stock = Stock::select('*')
                ->where('register_product_id', '=', $rowStock->register_product_id)
                ->where('reference_date', '=', $rowStock->reference_date)
                ->first();

            $stock->quantity -= $item->quantity;

            $stock->save();
        }
    }
}
