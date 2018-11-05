<?php

namespace FaimMedia\OAuth\Grant;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface;

use Phalcon\Mvc\User\Component as UserComponent;

abstract class AbstractGrant extends UserComponent {

	/**
	 * Issue an access token
	 */
	protected function issueAccessToken() {

	}

	/**
	 * Validate all provided scopes
	 */
	protected function validateScopes() {

	}

	/**
	 * Get storage engine
	 */
	abstract public function getStorageEngine();

	/**
	 * Set the storage engine
	 */
	final public function setStorageEngine(BaseInterface $storageEngine) {
		if(!($storageEngine instanceof BaseInterface)) {
			throw new StorageEngineException('Invalid storage engine, it must implement `BaseInterface`', StorageEngineException::INVALID_STORAGE_ENGINE);
		}

		return $this->_storageEngine;
	}
}