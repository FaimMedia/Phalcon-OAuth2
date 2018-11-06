<?php

namespace FaimMedia\OAuth\Exception;

use FaimMedia\OAuth\Exception\AbstractException;

class StorageModelException extends AbstractException {

	const INVALID_STORAGE_MODEL = -1;
	const INVALID_INSTANCE = -2;

	const SAVE_ERROR = -11;

}