<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return Inertia::render('Register/Clients/Index', [
            'clients' => $clients
        ]);
    }

    public function create()
    {
        return Inertia::render('Register/Clients/Create');
    }

    

    public function edit($id)
    {
        $client = Client::find($id);

        return Inertia::render('Register/Clients/Edit', [
            'client' => $client
        ]);
    }

    public function update(Request $request)
    {


        $client = Client::find($request->id);

        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;

        $client->save();

        return redirect()->action([ClientController::class, 'index']);
    }

    public function store(Request $request)
    {
        $client = new Client;

        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;

        $client->save();

        return redirect()->action([ClientController::class, 'index']);
    }

    public function remove($id)
    {
        $clients = Client::find($id);

        $clients->delete();

        return redirect()->action([ClientController::class, 'index']);
    }
}
