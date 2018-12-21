<?php

namespace FaimMedia\OAuth\Model\Traits;

use FaimMedia\OAuth\Model\Interfaces\ClientInterface;

use DateTime;

trait Client {

	protected $secret;
	public $name;
	public $description;
	public $active = 1;

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
			'id'              => 'id',
			'secret'          => 'secret',
			'name'            => 'name',
			'description'     => 'description',
			'active'          => 'active',
			'user_created'    => 'userCreated',
			'user_modified'   => 'userModified',
			'client_created'  => 'clientCreated',
			'client_modified' => 'clientModified',
			'date_created'    => 'dateCreated',
			'date_modified'   => 'dateModified',
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

	/**
	 * Get client secret
	 */
	protected function getSecret(): ?string {
		if($this->secret) {
			return $this->secret;
		}

		return null;
	}

	/**
	 * Check if secret is present
	 */
	public function hasSecret(): bool {
		return ($this->getSecret() !== null);
	}

	/**
	 * Check if client is active
	 */
	public function isActive(): bool {
		return (bool)$this->active;
	}

/* STATIC */

	/**
	 * Get client by id and secret
	 */
	public static function getOAuthClientByIdAndSecret(int $clientId, string $clientSecret): ?ClientInterface {

		$client = parent::findFirst([
			'id = :id: AND secret = :secret:',
			'bind' => [
				'id'      => $clientId,
				'secret'  => $clientSecret,
			],
		]);

		if(!$client) {
			return null;
		}

		return $client;
	}

	/**
	 * Get client by id
	 */
	public static function getOAuthClientById(int $clientId): ?self {

		$client = parent::findFirst([
			'id = :id:',
			'bind' => [
				'id'      => $clientId,
			],
		]);

		if(!$client) {
			return null;
		}

		return $client;
	}
}