<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\PostController;
use Inertia\Inertia;

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

Route::get('/', [CoinController::class, 'show']);

Route::get('/home', [CoinController::class, 'show'])->name('dashboard');

Route::name('newsletter.')->group(function () {
	Route::prefix('newsletter')->group(function () {
		Route::get('/', [PostController::class, 'show'])->name('list');

		Route::get('/newsletter/{id}', [PostController::class, 'detailView'])->name('detail');

		// Route::get('/add', [CoinController::class, 'createView'])->name('add');
		//
		// Route::post('/add', [CoinController::class, 'create'])->name('add');
	});
});

Route::name('coin.')->group(function () {
	Route::prefix('coin')->group(function () {
		Route::get('/{id}/detail', [CoinController::class, 'detailView'])->name('detail');

		Route::post('/{id}/vote', [CoinController::class, 'vote'])->name('vote');
	});
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
	Route::name('coin.')->group(function () {
		Route::prefix('coin')->group(function () {
			Route::get('/add', [CoinController::class, 'createView'])->name('add');

			Route::post('/add', [CoinController::class, 'create'])->name('add');	
		});
	});
});
