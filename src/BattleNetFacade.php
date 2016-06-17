<?php

namespace Reflex\SocialiteProviders\BattleNet;

use Illuminate\Support\Facades\Facade;
use Reflex\SocialiteProviders\BattleNet\BattleNet;

class BattleNetFacade extends Facade {

	/**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor() {
    	return BattleNet::class;
    }
}