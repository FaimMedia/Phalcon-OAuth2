<?php

namespace Controller;

use Phalcon\Mvc\Controller;

use FaimMedia\OAuth\Grant\ClientCredentialsGrant;

class Oauth extends Controller {

	public function authorizeAction() {

		$this->response->setStatusCode(403);

		$this->oauth->setGrantType(ClientCredentialsGrant::class);

		try {
			$this->oauth->startAuthorization();

			return [
				'success' => 1,
			];
		} catch(Exception $e) {
			return [
				'error' => $e->getMessage(),
			];
		}
	}
}