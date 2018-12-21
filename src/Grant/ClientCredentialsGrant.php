<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Grant\AbstractGrant,
	FaimMedia\OAuth\Grant\GrantTypeInterface;

use FaimMedia\OAuth\Model\Interfaces\ClientInterface;

use FaimMedia\OAuth\Exception\ClientCredentialsGrantException;

class ClientCredentialsGrant extends AbstractGrant implements GrantTypeInterface {

	/**
	 * Get identifier
	 */
	public function getIdentifier(): string {
		return 'client_credentials';
	}

	/**
	 * Authorize
	 */
	public function authorize(): bool {



		return true;
	}
}