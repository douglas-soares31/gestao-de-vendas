<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SaleOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $arrayLabels = array();
        $arrayDataPurchases = array();
        $arrayDataSales = array();
        $arrayCountPurchases = array();
        $arrayCountSales = array();

        $lastMonth = Carbon::now()->subDays(30)->format('Y-m-d');

        $countClients = Client::all()->count();
        $countSales = SaleOrder::all()->count();

        $salesOrders = DB::table('sale_orders')
            ->select(DB::raw('sum(amount) as amount'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(request_date,"%Y-%m-%d")'), '<', $lastMonth)
            ->first();

        $salesOrdersLastMonth = DB::table('sale_orders')
            ->select(DB::raw('sum(amount) as amount'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(request_date,"%Y-%m-%d")'), '>=', $lastMonth)
            ->first();

        $percSalesLastMonth = 0;
        if ($salesOrders->count > 0) {
            $percSalesLastMonth = round(($salesOrdersLastMonth->count / $salesOrders->count) * 100, 2);
        } else {
            $percSalesLastMonth = 100;
        }

        for ($date = Carbon::now()->subMonths(5); $date->diffInMonths(Carbon::now()->addMonth()) > 0; $date->addMonth()) {

            $salesOrders = DB::table('sale_orders')
                ->select(DB::raw('sum(amount) as amount'), DB::raw('count(*) as count'))
                ->where(DB::raw('DATE_FORMAT(request_date,"%Y-%m")'), '=', $date->format('Y-m'))
                ->first();

            $purchaseOrders = DB::table('purchase_orders')
                ->select(DB::raw('sum(amount) as amount'), DB::raw('count(*) as count'))
                ->where(DB::raw('DATE_FORMAT(request_date,"%Y-%m")'), '=', $date->format('Y-m'))
                ->first();

            $amountPurchase = ($purchaseOrders->amount > 0 ? $purchaseOrders->amount : 0);
            $countPurchase = ($purchaseOrders->count > 0 ? $purchaseOrders->count : 0);


            $amountSale = ($salesOrders->amount > 0 ? $salesOrders->amount : 0);
            $countSale = ($salesOrders->count > 0 ? $salesOrders->count : 0);

            array_push($arrayLabels, $date->format('Y-m-d 00:00:00'));
            array_push($arrayDataPurchases, $amountPurchase);
            array_push($arrayCountPurchases, $countPurchase);
            array_push($arrayDataSales, $amountSale);
            array_push($arrayCountSales, $countSale);
        }

        $arraySales = array(
            "countSales" => $countSales,
            "countSalesLastMonth" => $salesOrdersLastMonth->count,
            "percSalesLastMonth" => $percSalesLastMonth,
        );

        $salesTotal = DB::table('sale_items')
            ->select(DB::raw('SUM(sale_items.quantity) as totalQuantity'), DB::raw('SUM(sale_items.quantity * sale_items.unitary_value) as totalAmount'))
            ->first();

        if (!isset($salesTotal->totalAmount)) {
            $salesTotal->totalAmount = 0;
        }

        if (!isset($salesTotal->totalQuantity)) {
            $salesTotal->totalQuantity = 0;
        }

        $itemsSales = DB::table('sale_items')
            ->select('register_products.id', 'register_products.description', 'register_products.size', 'register_products.image_path', DB::raw('SUM(sale_items.quantity) as totalQuantity'), DB::raw('SUM(sale_items.quantity * sale_items.unitary_value) as totalAmount'), DB::raw('(SUM(sale_items.quantity * sale_items.unitary_value) / ' . $salesTotal->totalAmount . ') * 100 as percAmount'), DB::raw('(SUM(sale_items.quantity) / ' . $salesTotal->totalQuantity . ') * 100 as percQuantity'))
            ->join('register_products', 'register_products.id', '=', 'sale_items.register_product_id')
            ->groupBy('register_products.id')
            ->orderByDesc('totalAmount')
            ->limit(10)
            ->get();

        return Inertia::render('Dashboard', [
            'countClients' => $countClients,
            'arraySales' => $arraySales,
            'dataSalesPurchases' => array(
                "Labels" => $arrayLabels,
                "Purchases" => array(
                    "countP" => $arrayCountPurchases,
                    "amount" => $arrayDataPurchases,
                ),
                "Sales" => array(
                    "countS" => $arrayCountSales,
                    "amount" => $arrayDataSales,
                ),
            ),
            'itemsSales' => $itemsSales,
        ]);
    }
}
