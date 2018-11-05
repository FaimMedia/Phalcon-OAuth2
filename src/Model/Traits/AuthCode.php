<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait AuthCode {

	public $sessionId;
	public $redirectUri;
	public $expireDate;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_auth_code';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'                => 'id',
			'session_id'        => 'sessionId',
			'expire_date'       => 'expireDate',
		];
	}

/* GETTERS */

	/**
	 * Get session id
	 */
	public function getOAuthSessionId(): int {
		return (int)$this->oauthSessionId;
	}
}