<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/urls', [UrlShortenerController::class, 'urls'])->name('urls');
Route::post('/shorten', [UrlShortenerController::class, 'store'])->name('shorten');
Route::get('/{shortCode}', [UrlShortenerController::class, 'redirect'])->name('redirect');
