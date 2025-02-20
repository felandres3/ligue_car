<?php

use App\Models\Car;
use App\Models\League;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'league' => League::with('cars')->first(),
        ]);
    })->name('dashboard');

    Route::post('update/results', function (Request $request) {
        $results = $request->all();
        foreach ($results as $key => $result) {
            dd($result, $key);
            $car = Car::find($result['carId']);
            $car->result1 = $result['resultado1'];
            $car->result2 = $result['resultado2'];
            $car->save();
        }
    })->name('update.results');
});
