<?php

namespace FaimMedia\OAuth\Model\Traits;

trait Session {

	//const TYPE_CLIENT = 1;
	//const TYPE_USER = 2;

	public $clientId;
	public $type;
	public $ownerId;
	public $clientRedirectUri;

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
			'id'                  => 'id',
			'client_id'           => 'clientId',
			'type'                => 'type',
			'owner_id'            => 'ownerId',
			'client_redirect_uri' => 'clientRedirectUri',
		];
	}

/* GETTERS */
	/**
	 * Get client ID
	 */
	public function getClientId(): int {
		return (int)$this->clientId;
	}

	/**
	 * Get type
	 */
	public function getType(): int {
		return (int)$this->type;
	}

	/**
	 * Check if owner type is client
	 */
	public function isTypeClient(): bool {
		return ($this->getType() === self::TYPE_CLIENT);
	}

	/**
	 * Check if owner type is user
	 */
	public function isTypeUser(): bool {
		return ($this->getType() === self::TYPE_USER);
	}

	/**
	 * Get owner ID
	 */
	public function getOwnerId(): int {
		return (int)$this->ownerId;
	}

	/**
	 * Get client URI
	 */
	public function getClientRedirectUri(): ?string {
		if($this->clientRedirectUri) {
			return $this->clientRedirectUri;
		}

		return null;
	}
}