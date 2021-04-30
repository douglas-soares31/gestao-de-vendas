<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SaleOrderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $salesOrders = DB::table('clients')
            ->join('sale_orders', 'clients.id', '=', 'sale_orders.client_id')
            ->select('sale_orders.*', 'clients.phone', 'clients.name')
            ->get();

        return Inertia::render('Orders/Sales/Index', [
            'salesOrders' => $salesOrders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $clients = DB::table('clients')->orderBy('name', 'desc')->get();
        $products = DB::table('register_products')->orderBy('description', 'desc')->get();

        return Inertia::render('Orders/Sales/Create', [
            'clients' => $clients,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saleOrder = new SaleOrder();

        $saleOrder->client_id = $request->client_id;
        $saleOrder->amount = $request->subtotal;
        $saleOrder->request_date = $request->request_date;
        $saleOrder->departure_date = $request->departure_date;
        $saleOrder->paided_at = $request->paided_at;
        $saleOrder->payment_form = $request->payment_form;

        $saleOrder->save();

        $saleItem = new SaleItem();

        $saleItem->storeSaleItems($saleOrder, $request->sale_items);

        return redirect()->action([SaleOrderController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleOrder  $client
     * @return \Illuminate\Http\Response
     */
    public function show(SaleOrder $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleOrder  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleOrder = SaleOrder::find($id);
        $saleItems = DB::table('register_products')
            ->join('sale_items', 'register_products.id', '=', 'sale_items.register_product_id')
            ->where('sale_items.sale_order_id', $id)
            ->select('sale_items.*', 'register_products.description', DB::raw('quantity * unitary_value as total_item_value'))
            ->get();

        $clients = DB::table('clients')->orderBy('name', 'desc')->get();
        $products = DB::table('register_products')->orderBy('description', 'desc')->get();



        return Inertia::render('Orders/Sales/Edit', [
            'saleOrder' => $saleOrder,
            'saleItems' => $saleItems,
            'clients' => $clients,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleOrder  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $saleOrder = SaleOrder::find($request->id);

        $saleItem = new SaleItem();
        $saleItem->removeSaleItems($saleOrder);

        $saleOrder->client_id = $request->client_id;
        $saleOrder->amount = $request->subtotal;
        $saleOrder->request_date = $request->request_date;
        $saleOrder->departure_date = $request->departure_date;
        $saleOrder->paided_at = $request->paided_at;
        $saleOrder->payment_form = $request->payment_form;

        $saleOrder->save();

        $saleItem->storeSaleItems($saleOrder, $request->sale_items);

        return redirect()->action([SaleOrderController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleOrder  $client
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $saleOrder = SaleOrder::find($id);

        $saleItem = new SaleItem();
        $saleItem->removeSaleItems($saleOrder);

        $saleOrder->delete();

        return redirect()->action([SaleOrderController::class, 'index']);
    }
}
