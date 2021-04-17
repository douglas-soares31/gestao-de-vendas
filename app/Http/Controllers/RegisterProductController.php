<?php

namespace App\Http\Controllers;

use App\Models\RegisterProduct;
use Illuminate\Http\Request;
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
        $registerProduct->image_path = $request->image_path;

        $registerProduct->save();

        return redirect()->action([RegisterProductController::class, 'index']);
    }

    public function store(Request $request)
    {
        $registerProduct = new RegisterProduct;

        $registerProduct->description = $request->description;
        $registerProduct->size = $request->size;
        $registerProduct->image_path = $request->image_path;

        $registerProduct->save();

        return redirect()->action([RegisterProductController::class, 'index']);
    }

    public function remove($id)
    {
        $registerProducts = RegisterProduct::find($id);

        $registerProducts->delete();

        return redirect()->action([RegisterProductController::class, 'index']);
    }
}
