<?php

namespace Model;

use FaimMedia\OAuth\Model\Traits\ClientEndpoint as OAuthClientEndpoint;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface,
    FaimMedia\OAuth\Model\Interfaces\ClientEndpointInterface;

class ClientEndpoint extends AbstractModel implements BaseInterface, ClientEndpointInterface {
	use OAuthClientEndpoint;
};