<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait Scope {

	public $code;
	public $expireDate;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_scope';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'                => 'id',
			'code'              => 'code',
			'description'       => 'description',
		];
	}

/* GETTERS */

	/**
	 * Get code
	 */
	public function getCode(): string {
		return (string)$this->code;
	}

	/**
	 * Get description
	 */
	public function getDescription(): ?string {
		if(!$this->description) {
			return null;
		}

		return (string)$this->description;
	}

/**
 * STATIC
 */
	public function getOAuthScopes() {

	}
}