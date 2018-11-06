<?php

namespace FaimMedia\OAuth\Model\Interfaces;

interface ClientEndpointInterface {

	/**
	 * Get the OAuth client id
	 */
	public function getOAuthClientId(): int;

	/**
	 * Get redirect URI
	 */
	public function getRedirectUri(): string;
}