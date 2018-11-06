<?php

namespace Component\Event;

use Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Event,
    Phalcon\Mvc\Dispatcher\Exception as DispatchException;

use Phalcon\Mvc\User\Component as UserComponent;

class DispatcherEvent extends UserComponent {

	/**
	 * Check for JSON content and return
	 */
	public function afterDispatchLoop($event, $dispatcher) {
		$content = $dispatcher->getReturnedValue();

		if(is_array($content)) {
			$this->view->disable();

			$this->response->setJsonContent($content);
			$this->response->send();
		}
	}
}