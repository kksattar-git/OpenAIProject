<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\LogController;

Route::get('/summarize', function() {
    return view('summarize');
})->name('summarize');

Route::post('/summarize', [LogController::class, 'summarize'])->name('summarize.store');

Route::get('/history', [LogController::class, 'history'])->name('history');
