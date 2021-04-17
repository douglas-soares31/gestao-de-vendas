<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::all();

        return Inertia::render('Register/Providers/Index', [
            'providers' => $providers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Register/Providers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provider = new Provider;

        $provider->name = $request->name;
        $provider->phone = $request->phone;
        $provider->address = $request->address;

        $provider->save();

        return redirect()->action([ProviderController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = Provider::find($id);

        return Inertia::render('Register/Providers/Edit', [
            'provider' => $provider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $provider = Provider::find($request->id);

        $provider->name = $request->name;
        $provider->phone = $request->phone;
        $provider->address = $request->address;

        $provider->save();

        return redirect()->action([ProviderController::class, 'index']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $providers = Provider::find($id);

        $providers->delete();

        return redirect()->action([ProviderController::class, 'index']);
    }
}
