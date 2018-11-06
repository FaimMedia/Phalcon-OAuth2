<?php

namespace FaimMedia\OAuth\Grant;

interface GrantTypeInterface {

	/**
	 * Get the identifier code as must be provided in the request
	 */
	public function getIdentifier(): string;

}