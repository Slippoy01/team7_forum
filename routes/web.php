<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopikController;
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
    return redirect('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::post('/home/data', [HomeController::class, 'data'])->name('home.data');
Route::get('/home/search/{nama}', [HomeController::class, 'search'])->name('kategori.search');

Auth::routes();

Route::group([
    'prefix' => 'topik',
], function () {
    Route::get('/{topik_id}/{slug}', [TopikController::class, 'show'])->name('topik.show');
});

// Route khusus untuk yang sudah login
Route::group(['middleware' => ['auth']], function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::group([
        'prefix' => 'kategori',
    ], function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/{kategori_id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{kategori_id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{kategori_id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    Route::group([
        'prefix' => 'topik',
    ], function () {
        Route::get('/', [TopikController::class, 'index'])->name('topik');
        Route::get('/create', [TopikController::class, 'create'])->name('topik.create');
        Route::post('/', [TopikController::class, 'store'])->name('topik.store');
        Route::get('/{topik_id}', [TopikController::class, 'edit'])->name('topik.edit');
        Route::put('/{topik_id}', [TopikController::class, 'update'])->name('topik.update');
        Route::delete('/{topik_id}', [TopikController::class, 'destroy'])->name('topik.delete');
    });

    Route::group([
        'prefix' => 'komentar',
    ], function () {
        Route::post('/', [KomentarController::class, 'store'])->name('komentar.store');
        Route::post('/vote', [KomentarController::class, 'vote'])->name('komentar.vote');
        Route::post('/tanggapan', [KomentarController::class, 'store'])->name('komentar-tanggapan.store');
        Route::put('/{komentar_id}', [KomentarController::class, 'update'])->name('komentar.update');
        Route::delete('/{komentar_id}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
    });
});
