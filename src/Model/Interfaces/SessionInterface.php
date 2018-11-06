<?php

namespace FaimMedia\OAuth\Model\Interfaces;

interface SessionInterface {

	/**
	 * Get the OAuth session id
	 */
	public function getId(): int;

	/**
	 * Get OAuth client ID
	 */
	public function getOAuthClientId(): int;
}