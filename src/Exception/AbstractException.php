<?php

namespace FaimMedia\OAuth\Exception;

use Exception;

abstract class AbstractException extends Exception {

	protected $_field = [];
	protected $_responseCode;

	/**
	 * Set fields that caused the exception
	 */
	public function setField(): self {
		$this->_fields = func_get_args();

		return $this;
	}

	/**
	 * Get fields that caused the exception
	 */
	public function getField(): array {
		return $this->_field;
	}

	/**
	 * Set HTTP status response code that should be returned
	 */
	public function setResponseCode(int $responseCode): self {
		$this->_responseCode = $responseCode;

		return $this;
	}

	/**
	 * Get HTTP status response code that should be returned
	 */
	public function getResponseCode(): ?int {
		return $this->_responseCode;
	}
}