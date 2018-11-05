<?php

/**
 * DI Injectable OAuth service
 */

namespace FaimMedia\OAuth\Di;

use Phalcon\Di\Injectable as DiInjectable;

use FaimMedia\OAuth\Grant\GrantType;

class OAuth extends DiInjectable {

	/**
	 * Allow the X-Access-Token header
	 */
	const OPTION_ACCESS_TOKEN_X = 1;

	/**
	 * Allow the accessToken query key
	 */
	const OPTION_ACCESS_TOKEN_QUERY = 2;



	protected $_options;
	protected $_grantType;

	/**
	 * Constructor
	 */
	public function __construct(array $config = []) {
		if(empty($accessToken)) {
			$accessToken = $this->getRequestAccessToken();
		}

		$this
			->setGrantType(new GrantType())
			->setAccessTokenModel(new AccessToken())
			->setAuthCodeModel(new Auth)
			->setClient()
			->set

		if(!empty($accessToken)) {
			$this->validateAccessToken($accessToken);
		}
	}

	/**
	 * Set options
	 */
	public function setOptions(int $options, $remove = true): self {
		if($remove) {
			$this->_options = 0;
		}

		$this->_options |= $options;

		return $this;
	}

	/**
	 * Check if option is set
	 */
	public function hasOption(int $option): bool {
		return ($this->option & $option);
	}

	/**
	 * Tries to get the requests access token and honours the provided settings
	 */
	public function getRequestAccessToken(): ?string {

		$accessToken = null;

		if($this->hasOption(self::OPTION_ACCESS_TOKEN_X)) {
			$accessToken = $this->request->getHeader('X-Access-Token');
		}

	// rather using X-Access-Token, since most webservers remove the Authorization header from the request
	// however to honour the oAuth2 specs and guarantee the usability with oAuth clients
		if(empty($accessToken)) {
			$accessToken = $this->request->getHeader('Authorization');
		}

		if($this->hasOption(self::OPTION_ACCESS_TOKEN_QUERY) && empty($accessToken)) {
			$accessToken = $this->request->getQuery('accessToken');
		}

		return $accessToken;
	}

	/**
	 * Validates a provided access token
	 * If the access token is invalid, an AuthorizationException is returned
	 */
	public function validateAccessToken($accessToken = null) {
		if(!$accessToken) {
			$this->response->setStatusCode(401);
			throw new AuthorizationException('No access token is provided', AuthorizationException::ACCESS_TOKEN_MISSING);
		}

		$isBearer = substr($accessToken, 0, 7) == 'Bearer ';
		$isBasic  = substr($accessToken, 0, 6) == 'Basic ';

		if(!$isBearer && !$isBasic) {

		// get current access token type
			$accessTokenType = null;
			$split = explode(' ', $accessToken);
			if(count($split) > 1) {
				$accessTokenType = $split[0];
			}

			$this->response->setStatusCode(401);
			throw new AuthorizationException('The authorization token type `'.$accessTokenType.'` is invalid', AuthorizationException::ACCESS_TOKEN_TYPE_INVALID);
		}

		$username = null;
		if($isBasic) {
			if(strlen($accessToken) > 200) {
				$this->response->setStatusCode(413);
				throw new AuthorizationException('The authorization token is too long', AuthorizationException::ACCESS_TOKEN_TOO_LONG);
			}

			$accessToken = substr($accessToken, 6);
			$accessToken = base64_decode($accessToken, true);

			if(!$accessToken) {
				$this->response->setStatusCode(409);
				throw new AuthorizationException('The authorization token could not be decoded', AuthorizationException::ACCESS_TOKEN_DECODE_ERROR);
			}

			$explode = explode(':', $accessToken);

			if(count($explode) !== 2) {
				$this->response->setStatusCode(401);
				throw new AuthorizationException('The Basic Authorization header should contain both the username and the access token', AuthorizationException::ACCESS_TOKEN_BASIC_INVALID);
			}

			list($username, $accessToken) = $explode;
		}

		if($isBearer) {
			$accessToken = substr($accessToken, 7);
		}

		$auth = UserAccessToken::getAccessTokenByAccessToken($accessToken);
		if(!$auth) {
			$this->response->setStatusCode(401);
			throw new AuthorizationException('The provided access token is invalid', AuthorizationException::ACCESS_TOKEN_INVALID);
		}

		if($auth->isExpired()) {
			$this->response->setStatusCode(403);
			throw new AuthorizationException('The provided access token has expired', AuthorizationException::ACCESS_TOKEN_EXPIRED);
		}

		if($auth->isTypeUser() && !$auth->getUser()->isActive()) {
			$this->response->setStatusCode(403);
			throw new AuthorizationException('This user is inactive', AuthorizationException::INACTIVE_USER);
		}

		if($auth->isTypeClient() && !$auth->getApiClient()->isActive()) {
			$this->response->setStatusCode(403);
			throw new AuthorizationException('This client is inactive', AuthorizationException::INACTIVE_CLIENT);
		}

		$this->_auth = $auth;
		$this->isAuthorized = true;
	}

	public function isAuthorized() {
		return $this->isAuthorized;
	}

	/**
	 * Authorize
	 */
	public function authorize() {



	}

/* MAGIC */
	public function __call($name, $arg = []) {
		if($this->_auth instanceof UserAccessToken) {
			return call_user_func_array([$this->_auth, $name], $arg);
		}

		throw new AuthorizationException('Method `'.$name.'` does not exists on library `'.get_class($this).'`');
	}
}
