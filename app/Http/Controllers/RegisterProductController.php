<?php

namespace App\Http\Controllers;

use App\Models\RegisterProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RegisterProductController extends Controller
{
    public function index()
    {
        $registerProducts = RegisterProduct::all();

        return Inertia::render('Register/Products/Index', [
            'registerProducts' => $registerProducts
        ]);
    }

    public function create()
    {
        return Inertia::render('Register/Products/Create');
    }



    public function edit($id)
    {
        $registerProducts = RegisterProduct::find($id);

        return Inertia::render('Register/Products/Edit', [
            'registerProducts' => $registerProducts
        ]);
    }

    public function update(Request $request)
    {


        $registerProduct = RegisterProduct::find($request->id);

        $registerProduct->description = $request->description;
        $registerProduct->size = $request->size;
        $registerProduct->unit_purchase_value = $request->unit_purchase_value;
        $registerProduct->unit_sale_value = $request->unit_sale_value;

        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($registerProduct->image_path);

            $path = $request->file('image_path')->store('images/products', ['disk' => 'public']);
            $registerProduct->image_path = $path;
        }


        $registerProduct->save();

        return redirect()->action([RegisterProductController::class, 'index']);
    }

    public function store(Request $request)
    {
        $registerProduct = new RegisterProduct;

        $registerProduct->description = $request->description;
        $registerProduct->size = $request->size;
        $registerProduct->unit_purchase_value = $request->unit_purchase_value;
        $registerProduct->unit_sale_value = $request->unit_sale_value;

        $path = $request->file('image_path')->store('images/products', ['disk' => 'public']);
        $registerProduct->image_path = $path;

        $registerProduct->save();

        return redirect()->action([RegisterProductController::class, 'index']);
    }

    public function remove($id)
    {
        $registerProducts = RegisterProduct::find($id);

        Storage::disk('public')->delete($registerProducts->image_path);
        $registerProducts->delete();

        return redirect()->action([RegisterProductController::class, 'index']);
    }
}
