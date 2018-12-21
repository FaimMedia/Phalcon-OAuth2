<?php

namespace Model;

use FaimMedia\OAuth\Model\Traits\Client as OAuthClient;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface,
    FaimMedia\OAuth\Model\Interfaces\ClientInterface;

class Client extends AbstractModel implements BaseInterface, ClientInterface {
	use OAuthClient;

	public function isActive(): bool {
		return true;
	}
};