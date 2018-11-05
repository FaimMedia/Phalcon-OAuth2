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
	public function getIdentifier(): int {
		return 1;
	}

	/**
	 * Get identifier code
	 */
	public function getIdentifierCode(): string {
		return 'client_credentials';
	}

	/**
	 * Get storage engine
	 */
	final protected function getStorageEngine(): ClientInterface {
		return $this->_storageEngine;
	}

	/**
	 * Authorize
	 */
	public function authorize(): bool {

		$clientId = $this->request->getPost('client_id');
		$clientSecret = $this->request->getPost('client_secret');

		if(!$clientId) {
			$e = new ClientCredentialsGrantException('The parameter `client_id` is missing', ClientCredentialsGrantException::MISSING_CLIENT_ID);
			$e->setField('client_id');
			$e->setResponseCode(403);

			throw $e;
		}

		if(!$clientSecret) {
			$e = new ClientCredentialsGrantException('The parameter `client_secret` is missing', ClientCredentialsGrantException::MISSING_CLIENT_SECRET);
			$e->setField('client_secret');
			$e->setResponseCode(403);

			throw $e;
		}

		$storageEngine = $this->getStorageEngine();

		$client = call_user_func(get_class($storageEngine).'::getOAuthClientByIdAndSecret', $clientId, $clientSecret);
		if(!$client) {
			$e = new ClientCredentialsGrantException('Invalid client credentials provided', ClientCredentialsGrantException::INVALID_CLIENT_CREDENTIALS);
			$e->setField('client_id', 'client_secret');
			$e->setResponseCode(403);

			throw $e;
		}

		if(!$client->isActive()) {
			$e = new ClientCredentialsGrantException('Invalid client credentials provided', ClientCredentialsGrantException::CLIENT_INACTIVE);
			$e->setField('client_id', 'client_secret');
			$e->setResponseCode(403);

			throw $e;
		}

		$this->generateAccessToken();

		return true;
	}
}