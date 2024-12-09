<?php


use App\Http\Controllers\CetakController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/cetak', [CetakController::class, 'generateReport'])->name('cetak');
