<?php
namespace GPLogin;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;
class Provider extends AbstractProvider {
    public const IDENTIFIER = 'GPLogin';
    protected $scopes = ['identify','uuid'];
    protected $scopeSeparator = ' ';
    protected function getAuthUrl($state) {
        return $this->buildAuthUrlFromBase(
            'https://gridplay.net/oauth/authorize',
            $state
        );
    }
    protected function getTokenUrl() {
        return 'https://gridplay.net/oauth/token';
    }
    protected function getUserByToken($token) {
        $response = $this->getHttpClient()->get(
            'https://gridplay.net/api/users',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
    protected function mapUserToObject(array $user) {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'nickname' => $user['name'],
            'name'     => $user['name'],
            'uuid'     => $user['uuid'],
        ]);
    }
    protected function getTokenFields($code) {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
    public static function additionalConfigKeys() {
        return [];
    }
}