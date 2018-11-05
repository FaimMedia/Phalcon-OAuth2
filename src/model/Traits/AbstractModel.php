<?php

namespace FaimMedia\OAuth\Model\OAuth;

use Phalcon\Mvc\Model as MvcModel;

abstract class AbstractModel extends MvcModel {

	public $id;
	public $dateCreated;
	public $dateModified;

	/**
	 * Get ID
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Get date created
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}

	/**
	 * Get date modified
	 */
	public function getDateModified() {
		return $this->dateModified;
	}
}