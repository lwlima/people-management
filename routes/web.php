<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect('/people'));

    Route::get('/people', [PersonController::class, 'index'])->name('person.index');
    Route::post('/people', [PersonController::class, 'store'])->name('person.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/get-address-by-cep/{cep}', [AddressController::class, 'getAddressByCep'])->name('getAddressByCep');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
});

require __DIR__ . '/auth.php';
