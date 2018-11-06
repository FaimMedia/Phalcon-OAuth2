<?php

namespace Model;

use FaimMedia\OAuth\Model\Traits\Session as OAuthSession;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface,
    FaimMedia\OAuth\Model\Interfaces\SessionInterface;

class Session extends AbstractModel implements BaseInterface, SessionInterface {
	use OAuthSession;
};