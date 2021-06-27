<?php
namespace GPLogin;
use SocialiteProviders\Manager\SocialiteWasCalled;
class GPLoginExtendSocialite {
    public function handle(SocialiteWasCalled $socialiteWasCalled) {
        $socialiteWasCalled->extendSocialite('gplogin', Provider::class);
    }
}