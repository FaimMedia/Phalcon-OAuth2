<?php

namespace FaimMedia\OAuth\Model\Interfaces;

interface BaseInterface {

	/**
	 * Get source
	 */
	public function getSource(): string;

	public function getDateCreated();
	public function getDateModified();
}