<?php

namespace FaimMedia\OAuth\Grant;

interface GrantTypeInterface {

	/**
	 * Get the numeric identifier code, this will be saved in the database
	 */
	public function getIdentifier(): int;

	/**
	 * Get the identifier code as must be provided in the request
	 */
	public function getIdentifierCode(): string;

}