<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Dashboard utama: arahkan berdasarkan role
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'pemilik') {
            return redirect()->route('dashboard.pemilik');
        }

        return redirect()->route('dashboard.pencari');
    })->name('dashboard');

    // Dashboard Pencari Kos
    Route::get('/dashboard/pencari', function () {
        if (Auth::user()->role !== 'pencari') {
            return redirect()->route('dashboard');
        }

        return view('dashboard-pencari');
    })->name('dashboard.pencari');

    // Dashboard Pemilik Kos
    Route::get('/dashboard/pemilik', function () {
        if (Auth::user()->role !== 'pemilik') {
            return redirect()->route('dashboard');
        }

        return view('dashboard-pemilik');
    })->name('dashboard.pemilik');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
