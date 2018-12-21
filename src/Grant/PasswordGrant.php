<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Grant\AbstractGrant,
	FaimMedia\OAuth\Grant\GrantTypeInterface;

use FaimMedia\OAuth\Model\Interfaces\ClientInterface;

use FaimMedia\OAuth\Exception\PasswordGrantException;

class ClientCredentialsGrant extends AbstractGrant implements GrantTypeInterface {

	private $_callback;

	/**
	 * Get identifier
	 */
	public function getIdentifier(): string {
		return 'password';
	}

	/**
	 * Set username and password authentication validation callback
	 */
	public function setAuthenticationCallback(closure $callback) {
		$this->_callback = $callback;
	}

	/**
	 * Authorize
	 */
	public function authorize(): bool {

		if(!$this->request->isPost()) {
			throw (new PasswordGrantException('Invalid request method', PasswordGrantException::INVALID_REQUEST_METHOD))
				->setResponseCode(405);
		}

	// check client id parameter
		$username = $this->request->getPost('username');
		if(!$username) {
			throw (new PasswordGrantException('The parameter `username` is missing', PasswordGrantException::MISSING_USERNAME))
				->setField('username')
				->setResponseCode(422);
		}

	// check client secret parameter
		$clientSecret = $this->request->getPost('password');
		if(!$clientSecret) {
			throw (new PasswordGrantException('The parameter `password` is missing', PasswordGrantException::MISSING_CLIENT_SECRET))
				->setField('password')
				->setResponseCode(422);
		}

		if(!is_callable([$this, '_callback'])) {
			throw (new PasswordGrantException('The password grant callback is invalid', PasswordGrantException::INVALID_CALLBACK))
				->setResponseCode(500);
		}



		$this->getOAuth()->setClient($client);

		$this->issueAccessToken();

		return true;
	}
}