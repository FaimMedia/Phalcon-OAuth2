<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Grant\GrantInterface;

class GrantType implements GrantTypeInterface {

	/**
	 * Define constantes
	 */
	const GRANT_CLIENT_CREDENTIALS = 1;
	const GRANT_AUTHORIZATION_CODE = 2;
	const GRANT_PASSWORD = 3;
	const GRANT_REFRESH_TOKEN = 4;

	/**
	 * Get all grant types
	 */
	public function getGrantTypesArray(): array {
		return [
			'client_credentials' => self::GRANT_CLIENT_CREDIENTIALS,
			'authorization_code' => self::GRANT_AUTHORIZATION_CODE,
			'password'           => self::GRANT_PASSWORD,
			'refresh_token'      => self::REFRESH_TOKEN,
		];
	}

	/**
	 * Validate if grant type is valid
	 */
	public function isValid(string $grantType): bool {
		$grantTypes = $this->getGrantTypesArray();

		return (!in_array($grantType, $grantTypes));
	}

	/**
	 * Get grant type integer
	 * Returns null if the grant type is invalid
	 */
	public function getGrantTypeId(string $grantType): ?int {
		if(!$this->isValid($grantType)) {
			return null;
		}

		$grantTypes = $this->getGrantTypesArray();

		return $grantTypes[$grantType];
	}
}