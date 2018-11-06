<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait ClientEndpoint {

	protected $oauthClientId;
	public $redirectUri;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_client_endpoint';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'              => 'id',
			'oauth_client_id' => 'oauthClientId',
			'redirect_uri'    => 'redirectUri',
		];
	}

/* GETTERS */

	/**
	 * Get oauth client ID
	 */
	public function getOauthClientId(): int {
		return (int)$this->oauthClientId;
	}

	/**
	 * Get redirect URI
	 */
	public function getRedirectUri(): string {
		return (string)$this->redirectUri;
	}
}