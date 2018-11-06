<?php

namespace Model;

use Phalcon\Mvc\Model;

abstract class AbstractModel extends Model {

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