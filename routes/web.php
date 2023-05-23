<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
        $upload_id = Str::ulid()->toBase58();
        return response()->json([
            'api_token' => Auth::user()->api_token,
            'endpoint' => route('photos.upload', ['api_token' => Auth::user()->api_token, 'upload_id' => $upload_id]),
            'max_file_size' => config('upload.max_file_size'),
            'companion_url' => config('upload.companion_url'),
            'count' => config('upload.count'),
            'limit' => config('upload.limit'),
            'timeout' => config('upload.timeout'),
            'upload_id' => $upload_id,
        ]);
    } else {
        return response()->json(['api_token' => ''], 403);
    }
});

Route::middleware(['verified'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/photos', [App\Http\Controllers\PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photos/view/{photo}', [App\Http\Controllers\PhotoController::class, 'view'])->name('photos.view');
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

    Route::get('/category', App\Http\Livewire\Category::class)->name('category.index');

    Route::get('/options', [App\Http\Controllers\OptionController::class, 'index'])->name('options.index');
    Route::put('/options', [App\Http\Controllers\OptionController::class, 'update'])->name('options.update');
});

Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm']);
Route::post('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
Route::get('/admin/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswodController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswodController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('admin.password.update');

Route::middleware(['auth:admin'])->group(function(){
    Route::get('/admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
});
