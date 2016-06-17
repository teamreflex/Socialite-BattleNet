<?php

namespace Reflex\SocialiteProviders\BattleNet;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Reflex\SocialiteProviders\BattleNet\BattleNet;

class BattleNetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(BattleNet::class, function()
        {
            return new BattleNet;
        });
    }
}