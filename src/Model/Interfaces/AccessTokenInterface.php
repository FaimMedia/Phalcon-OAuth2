<?php

namespace FaimMedia\OAuth\Model\Interfaces;

interface AccessTokenInterface {

	/**
	 * Get the OAuth session id
	 */
	public function getId(): int;

	/**
	 * Get access token
	 */
	public function getAccessToken(): string;

	/**
	 * Get session ID
	 */
	public function getOAuthSessionId(): int;

	/**
	 * Get expire date
	 */
	public function getExpireDate();
}