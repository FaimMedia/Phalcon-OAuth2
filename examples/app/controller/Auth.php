<?php

namespace Controller;

use Phalcon\Mvc\Controller;

class Auth extends Controller {

	public function authorizeAction() {

		$this->oauth->authorize();
	}
}