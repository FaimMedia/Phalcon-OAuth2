<?php

namespace FaimMedia\OAuth\Model\Interfaces;

interface ClientInterface {

	public function isActive(): bool;

	public static function getOAuthClientByIdAndSecret(int $clientId, string $clientSecret): self;
}