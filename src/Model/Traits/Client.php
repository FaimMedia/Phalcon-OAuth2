<?php

namespace FaimMedia\OAuth\Model\Traits;

use DateTime;

trait Client {

	protected $secret;
	public $name;
	public $description;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_client';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'            => 'id',
			'secret'        => 'secret',
			'name'          => 'name',
			'description'   => 'description',
		];
	}

/* GETTERS */

	/**
	 * Get name
	 */
	public function getName(): name {
		return (string)$this->name;
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