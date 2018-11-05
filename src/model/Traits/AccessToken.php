<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait AccessToken {

	public $oauthSessionId;
	public $expireDate;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_access_token';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'                => 'id',
			'oauth_session_id'  => 'oauthSessionId',
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

	/**
	 * Get expire date
	 */
	public function getExpireDate($asDateTime = false) {
		if($asDateTime && $this->expireDate) {
			return new DateTime($this->expireDate);
		}

		return $this->expireDate;
	}
}