<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $users = Client::all();

        return view('clients.index', [
            'users' => $users
        ]);
    }

    public function create()
    {

    }

    public function remove()
    {

    }

    public function update()
    {

    }
}
