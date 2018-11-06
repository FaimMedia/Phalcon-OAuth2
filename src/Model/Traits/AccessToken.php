<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait AccessToken {

	public $id;
	public $accessToken;
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
			'access_token'      => 'accessToken',
			'oauth_session_id'  => 'oauthSessionId',
			'expire_date'       => 'expireDate',
			'user_created'      => 'userCreated',
			'user_modified'     => 'userModified',
			'date_created'      => 'dateCreated',
			'date_modified'     => 'dateModified',
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
	 * Get access token
	 */
	public function getAccessToken(): string {
		return $this->accessToken;
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