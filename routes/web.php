<?php

use App\Events\WebSocketDemoEvent;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
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
    broadcast(new WebSocketDemoEvent('some-data'));

    return view('welcome');
});
Auth::routes();

Route::get('/chat', [MessageController::class, 'index'])->name('msg.index');
Route::get('/message', [MessageController::class, 'FetchMessage']);
Route::post('/message', [MessageController::class, 'StoreMessage']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
