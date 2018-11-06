<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface;

use Phalcon\Mvc\User\Component as UserComponent;

use FaimMedia\OAuth\Di\OAuth;

abstract class AbstractGrant extends UserComponent {

	protected $_oauth;

	/**
	 * Constructor
	 */
	public function __construct(OAuth $oAuth) {
		if(is_callable('parent::__construct')) {
			parent::__construct();
		}

		$this->setOAuth($oAuth);
	}

	/**
	 * Set OAuth
	 */
	protected function setOAuth(OAuth $oauth): self {
		$this->_oauth = $oauth;

		return $this;
	}

	/**
	 * Get OAuth
	 */
	protected function getOAuth(): OAuth {
		return $this->_oauth;
	}

	/**
	 * Issue an access token
	 */
	protected function issueAccessToken() {

		$sessionModel = $this->getOAuth()->getStorageSession(true);
		$session = new $sessionModel;
		$session->assign([
			'oauthClientId' => $this->getOAuth()->getClient()->getId(),
			'type'          => 1,
		]);
		$session->save();

		$accessTokenModel = $this->getOAuth()->getStorageAccessToken(true);
		$accessToken = new $accessTokenModel;
		$accessToken->assign([
			'oauthAccessToken' => $accessToken,
			'oauthSessionId'   => $session->getId(),
			'expireDate'       => null,
		]);
		$accessToken->save();

	}

	/**
	 * Validate all provided scopes
	 */
	protected function validateScopes() {

	}

	/**
	 * Get storage engine
	 */
	protected function getStorageEngine(string $storageEngine) {
		return $this->getOAuth()->getStorageEngine($storageEngine);
	}


}