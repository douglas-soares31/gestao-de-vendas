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

        return Inertia::render('Clients/Index', [
            'clients' => $clients
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function remove($id)
    {
        $clients = Client::find($id);

        $clients->delete();
    }

    public function update()
    {
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
}
