<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return response()->json([
        'message' => 'Yay! You made it 🚀'
    ]);
});
Route::controller(LinkController::class)->group(function () {
    Route::get('/{link}', 'redirectLink');
    Route::post('/links', 'store');
});
