<?php

namespace FaimMedia\OAuth\Exception;

use FaimMedia\OAuth\Exception\AbstractException;

class ClientCredentialsGrantException extends AbstractException {

	const MISSING_CLIENT_ID = -1;
	const MISSING_CLIENT_SECRET = -2;
	const INVALID_CLIENT_CREDENTIALS = -3;
	const CLIENT_INACTIVE = -4;

}