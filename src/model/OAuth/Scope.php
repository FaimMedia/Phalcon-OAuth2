<?php

namespace FaimMedia\OAuth\Model\OAuth;

use FaimMedia\OAuth\Model\OAuth\AbstractModel;

use DateTime;

class Scope extends AbstractModel {

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
}