<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/produk', \App\Livewire\Produk::class)->name('data.produk');
    Route::get('/formTimbangan', \App\Livewire\FormTimbangan::class)->name('form.timbangan');
    Route::get('/report-gk', \App\Livewire\ViewReportBS::class)->name('report.gk');

    Route::post('/emit_weight', [\App\Livewire\FormTimbangan::class, 'handleWeightData']);
});
