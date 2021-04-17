<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RegisterExpenseController;
use App\Http\Controllers\RegisterProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        //'laravelVersion' => Application::VERSION,
        //'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('register')->group(function () {

        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('clients');
            Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
            Route::post('/', [ClientController::class, 'store'])->name('clients.store');
            Route::delete('/{id}/remove', [ClientController::class, 'remove'])->name('clients.remove');
            Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
            Route::put('/{id}/update', [ClientController::class, 'update'])->name('clients.update');
        });

        Route::prefix('providers')->group(function () {
            Route::get('/', [ProviderController::class, 'index'])->name('providers');
            Route::get('/create', [ProviderController::class, 'create'])->name('providers.create');
            Route::post('/', [ProviderController::class, 'store'])->name('providers.store');
            Route::delete('/{id}/remove', [ProviderController::class, 'remove'])->name('providers.remove');
            Route::get('/{id}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
            Route::put('/{id}/update', [ProviderController::class, 'update'])->name('providers.update');
        });

        Route::prefix('expenses')->group(function () {
            Route::get('/', [RegisterExpenseController::class, 'index'])->name('register.expenses');
            Route::get('/create', [RegisterExpenseController::class, 'create'])->name('register.expenses.create');
            Route::post('/', [RegisterExpenseController::class, 'store'])->name('register.expenses.store');
            Route::delete('/{id}/remove', [RegisterExpenseController::class, 'remove'])->name('register.expenses.remove');
            Route::get('/{id}/edit', [RegisterExpenseController::class, 'edit'])->name('register.expenses.edit');
            Route::put('/{id}/update', [RegisterExpenseController::class, 'update'])->name('register.expenses.update');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [RegisterProductController::class, 'index'])->name('register.products');
            Route::get('/create', [RegisterProductController::class, 'create'])->name('register.products.create');
            Route::post('/', [RegisterProductController::class, 'store'])->name('register.products.store');
            Route::delete('/{id}/remove', [RegisterProductController::class, 'remove'])->name('register.products.remove');
            Route::get('/{id}/edit', [RegisterProductController::class, 'edit'])->name('register.products.edit');
            Route::put('/{id}/update', [RegisterProductController::class, 'update'])->name('register.products.update');
        });
    });
});
