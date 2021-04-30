<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $purchasesOrders = DB::table('providers')
            ->join('purchase_orders', 'providers.id', '=', 'purchase_orders.provider_id')
            ->select('purchase_orders.*', 'providers.phone', 'providers.name')
            ->get();

        return Inertia::render('Orders/Purchases/Index', [
            'purchasesOrders' => $purchasesOrders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $providers = DB::table('providers')->orderBy('name', 'desc')->get();
        $products = DB::table('register_products')->orderBy('description', 'desc')->get();

        return Inertia::render('Orders/Purchases/Create', [
            'providers' => $providers,
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
        $purchaseOrder = new PurchaseOrder;

        $purchaseOrder->provider_id = $request->provider_id;
        $purchaseOrder->amount = $request->subtotal;
        $purchaseOrder->request_date = $request->request_date;
        $purchaseOrder->entry_date = $request->entry_date;
        $purchaseOrder->paided_at = $request->paided_at;
        $purchaseOrder->payment_form = $request->payment_form;

        $purchaseOrder->save();

        $purchaseItem = new PurchaseItem();

        $purchaseItem->storePurchaseItems($purchaseOrder, $request->purchase_items);

        return redirect()->action([PurchaseOrderController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseItems = DB::table('register_products')
            ->join('purchase_items', 'register_products.id', '=', 'purchase_items.register_product_id')
            ->where('purchase_items.purchase_order_id', $id)
            ->select('purchase_items.*', 'register_products.description', DB::raw('quantity * unitary_value as total_item_value'))
            ->get();

        $providers = DB::table('providers')->orderBy('name', 'desc')->get();
        $products = DB::table('register_products')->orderBy('description', 'desc')->get();



        return Inertia::render('Orders/Purchases/Edit', [
            'purchaseOrder' => $purchaseOrder,
            'purchaseItems' => $purchaseItems,
            'providers' => $providers,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $purchaseOrder = PurchaseOrder::find($request->id);

        $purchaseItem = new PurchaseItem();
        $purchaseItem->removePurchaseItems($purchaseOrder);

        $purchaseOrder->provider_id = $request->provider_id;
        $purchaseOrder->amount = $request->subtotal;
        $purchaseOrder->request_date = $request->request_date;
        $purchaseOrder->entry_date = $request->entry_date;
        $purchaseOrder->paided_at = $request->paided_at;
        $purchaseOrder->payment_form = $request->payment_form;

        $purchaseOrder->save();

        $purchaseItem->storePurchaseItems($purchaseOrder, $request->purchase_items);

        return redirect()->action([PurchaseOrderController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $provider
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);

        $purchaseItem = new PurchaseItem();
        $purchaseItem->removePurchaseItems($purchaseOrder);

        $purchaseOrder->delete();

        return redirect()->action([PurchaseOrderController::class, 'index']);
    }
}
