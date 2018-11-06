<?php

namespace FaimMedia\OAuth\Exception;

use FaimMedia\OAuth\Exception\AbstractException;

class GrantTypeException extends AbstractException {

	const MISSING_GRANT_TYPE = -1;
	const INVALID_GRANT_TYPE = -2;

}