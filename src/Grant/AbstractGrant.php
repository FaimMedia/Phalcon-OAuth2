<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface;

use Phalcon\Mvc\User\Component as UserComponent;

use Phalcon\Security\Random;

use FaimMedia\OAuth\Di\OAuth;

use FaimMedia\OAuth\Exception\StorageModelException;

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

	// generate session
		$sessionModel = $this->getOAuth()->getStorageSession(true);
		$session = new $sessionModel;
		$session->assign([
			'oauthClientId' => $this->getOAuth()->getClient()->getId(),
			'type'          => 1,
		]);
		if(!$session->save()) {
			throw new StorageModelException('Could not generate session', StorageModelException::SAVE_ERROR);
		}

	// generate access token
		$random = new Random();
		$accessTokenHash = $random->base64Safe(40);

		$accessTokenModel = $this->getOAuth()->getStorageAccessToken(true);
		$accessToken = new $accessTokenModel;
		$accessToken->assign([
			'accessToken'      => $accessTokenHash,
			'oauthSessionId'   => $session->getId(),
			'expireDate'       => null,
		]);
		if(!$accessToken->save()) {
			throw new StorageModelException('Could not generate access token', StorageModelException::SAVE_ERROR);
		}

	// generate refresh token
		$refreshTokenHash = $random->base64Safe(50);

		$refreshTokenModel = $this->getOAuth()->getStorageRefreshToken(true);
		$refreshToken = new $refreshTokenModel;
		$refreshToken->assign([
			'refreshToken'       => $refreshTokenHash,
			'oauthAccessTokenId' => $accessToken->getId(),
			'expireDate'         => null,
		]);
		if(!$refreshToken->save()) {
			throw new StorageModelException('Could not generate refresh token', StorageModelException::SAVE_ERROR);
		}

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