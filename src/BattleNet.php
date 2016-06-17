<?php

namespace Reflex\SocialiteProviders\BattleNet;

use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class BattleNet {

	/**
	 * Puts the region into the session and returns the redirect.
	 * 
	 * @param  string $region
	 * @return Response
	 */
    public function redirect($region = 'us')
    {
        Session::put('bnet.region', $region);
		return Socialite::with('battlenet')->redirect();
    }
}