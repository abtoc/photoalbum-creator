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
        return response()->json([
            'api_token' => Auth::user()->api_token,
            'endpoint' => route('photos.upload', ['api_token' => Auth::user()->api_token]),
            'max_file_size' => config('upload.max_file_size'),
            'companion_url' => config('upload.companion_url'),
            'count' => config('upload.count'),
            'limit' => config('upload.limit'),
            'timeout' => config('upload.timeout'),
        ]);
    } else {
        return response()->json(['api_token' => ''], 403);
    }
});

Route::middleware(['verified'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/photos', [App\Http\Controllers\PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photos/{photo}/view', [App\Http\Controllers\PhotoController::class, 'view'])->name('photos.view');
    Route::get('/photos/download/{photo}', [App\Http\Controllers\PhotoController::class, 'download'])->name('photos.download');

    Route::get('/albums', [App\Http\Controllers\AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [App\Http\Controllers\AlbumController::class, 'create'])->name('albums.create');
    Route::post('/albums', [App\Http\Controllers\AlbumController::class, 'store'])->name('albums.store');
    Route::get('/album/{album}/edit', [App\Http\Controllers\AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/album/{album}', [App\Http\Controllers\AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/album/{album}', [App\Http\Controllers\AlbumController::class, 'destroy'])->name('albums.destroy');
    Route::delete('/albums/{album}/force', [App\Http\Controllers\AlbumController::class, 'forceDestroy'])->name('albums.force');
    Route::put('/albums/{album}/restore', [App\Http\Controllers\AlbumController::class, 'restore'])->name('albums.restore');
    Route::get('/albums/{album}/cover', [\App\Http\Controllers\AlbumController::class, 'cover'])->name('albums.cover');
    Route::post('/albums/{album}/make', [App\Http\Controllers\AlbumController::class, 'make'])->name('albums.make');
    Route::get('/albums/{album}/download', [App\Http\Controllers\AlbumController::class, 'download'])->name('albums.download');

    Route::get('/albums/{album}', [App\Http\Controllers\PageController::class, 'index'])->name('pages.index');
});
