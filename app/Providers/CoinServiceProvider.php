<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CoinServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		require_once app_path() . '/Helpers/Coin/HasLogo.php';
		require_once app_path() . '/Helpers/Coin/HasFeaturedPhoto.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
