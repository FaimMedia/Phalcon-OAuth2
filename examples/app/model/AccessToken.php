<?php

namespace Model;

use FaimMedia\OAuth\Model\Traits\AccessToken as OAuthAccessToken;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface,
    FaimMedia\OAuth\Model\Interfaces\AccessTokenInterface;

class AccessToken extends AbstractModel implements BaseInterface, AccessTokenInterface {
	use OAuthAccessToken;
};