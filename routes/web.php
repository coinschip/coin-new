<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
	Route::get('/dashboard', function () {
	    return Inertia::render('Coin/Show', [
			'coins' => [
				[
					'logo' => null,
					'name' => 'Bitcoin',
					'symbol' => 'BTC',
					'price' => 0.1,
					'yesterday' => 0.004,
					'capital' => 1000000,
					'launched' => '10/20/2020',
				],
				[
					'logo' => null,
					'name' => 'Doge',
					'symbol' => 'DOGE',
					'price' => 5,
					'yesterday' => 2.5,
					'capital' => 1000000,
					'launched' => '10/20/2020',
				],
				[
					'logo' => null,
					'name' => 'BitTorrent Token',
					'symbol' => 'BTT',
					'price' => 5,
					'yesterday' => 10,
					'capital' => 1000000,
					'launched' => '10/20/2020',
				]
			]
		]);
	})->name('dashboard');

	Route::name('coin.')->group(function () {
		Route::prefix('coin')->group(function () {
			Route::get('/', function () {
			    return Inertia::render('Coin/Show');
			})->name('list');

			Route::get('/add', function () {
			    return Inertia::render('Coin/Create');
			})->name('add');

			Route::post('/add', function () {
			    return Inertia::render('Dashboard');
			})->name('add');
		});
	});
});
