<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/api-token', function(){
    if(Auth::check()){
        return response()->json(['api_token' => Auth::user()->api_token]);
    } else {
        return response()->json(['api_token' => ''], 403);
    }
});

Route::middleware(['verified'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/photos', [App\Http\Controllers\PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photos/view/{photo}', [App\Http\Controllers\PhotoController::class, 'view'])->name('photos.view');
    Route::get('/photos/download/{photo}', [App\Http\Controllers\PhotoController::class, 'download'])->name('photos.download');
});
