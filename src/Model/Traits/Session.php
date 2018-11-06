<?php

namespace FaimMedia\OAuth\Model\Traits;

trait Session {

	//const TYPE_CLIENT = 1;
	//const TYPE_USER = 2;

	public $id;
	public $clientId;
	public $type;
	public $ownerId;
	public $clientRedirectUri;

/* INIT */
	/**
	 * Get database table source
	 */
	public function getSource(): string {
		return 'oauth_session';
	}

	/**
	 * Get column map
	 */
	public function columnMap(): array {
		return [
			'id'                  => 'id',
			'oauth_client_id'     => 'oauthClientId',
			'type'                => 'type',
			'oauth_owner_id'      => 'oauthOwnerId',
			'client_redirect_uri' => 'clientRedirectUri',
			'user_created'        => 'userCreated',
			'user_modified'       => 'userModified',
			'date_created'        => 'dateCreated',
			'date_modified'       => 'dateModified',
		];
	}

/* GETTERS */

	/**
	 * Get ID
	 */
	public function getId(): int {
		return (int)$this->id;
	}

	/**
	 * Get client ID
	 */
	public function getOAuthClientId(): int {
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