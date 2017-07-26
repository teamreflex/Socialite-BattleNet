<?php

namespace Reflex\SocialiteProviders\BattleNet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Request $request, $clientId, $clientSecret, $redirectUrl)
    {
        $this->region = Session::get('bnet.region', 'us');
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl);
    }

    /**
     * Region to use when querying BattleNet.
     *
     * @var string
     */
    protected $region = 'us';

    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'BATTLENET';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = '';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase("https://{$this->region}.battle.net/oauth/authorize", $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return "https://{$this->region}.battle.net/oauth/token";
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get("https://{$this->region}.api.battle.net/account/user", [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'nickname' => $user['battletag'],
            'name'     => null,
            'email'    => null,
            'avatar'   => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function scopes($scopes)
    {
        $this->scopes = array_unique(array_filter(array_merge($this->scopes, $scopes)));
        return $this;
    }
}
