<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
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

        foreach ($request->purchase_items as $item) {

            $purchaseItem = new PurchaseItem();
            $item = (object) $item;

            $purchaseItem->purchase_order_id = $purchaseOrder->id;
            $purchaseItem->register_product_id = $item->id;
            $purchaseItem->quantity = $item->quantity;
            $purchaseItem->unitary_value = $item->unitary_value;

            $purchaseItem->save();
        }

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
        $provider = PurchaseOrder::find($id);

        return Inertia::render('Orders/Purchases/Edit', [
            'provider' => $provider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $provider)
    {
        $provider = PurchaseOrder::find($request->id);

        $provider->name = $request->name;
        $provider->phone = $request->phone;
        $provider->address = $request->address;

        $provider->save();

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
        $purchasesOrders = PurchaseOrder::find($id);

        $purchasesOrders->delete();

        return redirect()->action([PurchaseOrderController::class, 'index']);
    }
}
