<?php

namespace App\Http\Controllers;

use App\Models\RegisterExpense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterExpenseController extends Controller
{
    public function index()
    {
        $registerExpenses = RegisterExpense::all();

        return Inertia::render('Register/Expenses/Index', [
            'registerExpenses' => $registerExpenses
        ]);
    }

    public function create()
    {
        return Inertia::render('Register/Expenses/Create');
    }

    

    public function edit($id)
    {
        $registerExpenses = RegisterExpense::find($id);

        return Inertia::render('Register/Expenses/Edit', [
            'registerExpenses' => $registerExpenses
        ]);
    }

    public function update(Request $request)
    {


        $registerExpense = RegisterExpense::find($request->id);

        $registerExpense->description = $request->description;

        $registerExpense->save();

        return redirect()->action([RegisterExpenseController::class, 'index']);
    }

    public function store(Request $request)
    {
        $registerExpense = new RegisterExpense;

        $registerExpense->description = $request->description;

        $registerExpense->save();

        return redirect()->action([RegisterExpenseController::class, 'index']);
    }

    public function remove($id)
    {
        $registerExpenses = RegisterExpense::find($id);

        $registerExpenses->delete();

        return redirect()->action([RegisterExpenseController::class, 'index']);
    }
}
