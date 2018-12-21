<?php

/**
 * DI Injectable OAuth service
 */

namespace FaimMedia\OAuth\Di;

use Phalcon\Di\Injectable as DiInjectable;

use FaimMedia\OAuth\Model\Interfaces\BaseInterface,
    FaimMedia\OAuth\Model\Interfaces\ClientInterface;

use FaimMedia\OAuth\Grant\GrantTypeInterface;

use FaimMedia\OAuth\Exception\OAuthException,
    FaimMedia\OAuth\Exception\GrantTypeException,
    FaimMedia\OAuth\Exception\StorageModelException;

class OAuth extends DiInjectable {

	/**
	 * Allow the X-Access-Token header
	 */
	const OPTION_ACCESS_TOKEN_X = 1;

	/**
	 * Allow the accessToken query key
	 */
	const OPTION_ACCESS_TOKEN_QUERY = 2;

	protected $_client;
	protected $_user;
	protected $_session;
	protected $_accessToken;

	protected $_options;
	protected $_grantTypes = [];
	protected $_storageModels = [];

/* INIT */
	/**
	 * Constructor
	 */
	public function __construct(array $config = []) {
		if(empty($accessToken)) {
			$accessToken = $this->getRequestAccessToken();
		}

		foreach($config['storage'] as $storage) {
			var_dump(class_implements($storage));
		}

		die;

		if(!empty($accessToken)) {
			$this->validateAccessToken($accessToken);
		}
	}

/* OPTIONS */
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
		return ($this->_options & $option);
	}

/* GRANT TYPES */

	/**
	 * Set grant type
	 */
	public function setGrantType(string $grantTypeClassName): self {

		$grantTypeInstance = new $grantTypeClassName($this);

		if(!($grantTypeInstance instanceof GrantTypeInterface)) {
			throw new StorageModelException($grantTypeClassName.' must implement `'.BaseInterface::class.'`', StorageModelException::INVALID_INSTANCE);
		}

		$this->_grantTypes[$grantTypeInstance->getIdentifier()] = $grantTypeInstance;

		return $this;
	}

	/**
	 * Check if grant type exists
	 */
	public function hasGrantType(string $grantType): bool {
		return (array_key_exists($grantType, $this->_grantTypes));
	}

	/**
	 * Get the instance based on the provided grant type
	 * If the grant type is invalid, an exception will be thrown
	 */
	protected function getGrantType(string $grantType = null) {

		if(empty($grantType)) {
			$e = new GrantTypeException('Missing `grant_type` parameter', GrantTypeException::MISSING_GRANT_TYPE);
			$e->setField('grant_type');
			$e->setResponseCode(409);

			throw $e;
		}

		if(!array_key_exists($grantType, $this->_grantTypes)) {
			$e = new GrantTypeException('Invalid `grant_type` parameter provided', GrantTypeException::INVALID_GRANT_TYPE);
			$e->setField('grant_type');
			$e->setResponseCode(409);

			throw $e;
		}

		return $this->_grantTypes[$grantType];
	}

/* STORAGE ENGINES */
	/**
	 * Get storage engine correspondending with the provided grant type
	 */
	public function getStorageModel(string $identifier, bool $className = false) {
		if(!array_key_exists($identifier, $this->_storageModels)) {
			throw new StorageModelException('Storage model `'.$identifier.'` does not exist', StorageModelException::INVALID_STORAGE_MODEL);
		}

		$instance = $this->_storageModels[$identifier];

		if($className) {
			return get_class($instance);
		}

		return $instance;
	}

	/**
	 * Set storage engine correspondending with the grant type
	 */
	public function setStorageModel(string $identifier, BaseInterface $storageModel): self {
		$this->_storageModels[$identifier] = $storageModel;

		return $this;
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
	 * Validate client credentials
	 */
	protected function validateClientCredentials(): ClientInterface {
		if(!$this->request->isPost()) {
			throw (new ClientCredentialsGrantException('Invalid request method', ClientCredentialsGrantException::INVALID_REQUEST_METHOD))
				->setResponseCode(405);
		}

	// check client id parameter
		$clientId = $this->request->getPost('client_id');
		if(!$clientId) {
			throw (new ClientCredentialsGrantException('The parameter `client_id` is missing', ClientCredentialsGrantException::MISSING_CLIENT_ID))
				->setField('client_id')
				->setResponseCode(403);
		}

	// check client secret parameter
		$clientSecret = $this->request->getPost('client_secret');
		if(!$clientSecret) {
			throw (new ClientCredentialsGrantException('The parameter `client_secret` is missing', ClientCredentialsGrantException::MISSING_CLIENT_SECRET))
				->setField('client_secret')
				->setResponseCode(403);
		}

		$storageEngine = $this->getStorageClient();

		$client = call_user_func(get_class($storageEngine).'::getOAuthClientByIdAndSecret', $clientId, $clientSecret);
		if(!$client) {
			throw (new ClientCredentialsGrantException('Invalid client credentials provided', ClientCredentialsGrantException::INVALID_CLIENT_CREDENTIALS))
				->setField('client_id', 'client_secret')
				->setResponseCode(403);
		}

		if(!$client->isActive()) {
			throw (new ClientCredentialsGrantException('Invalid client credentials provided', ClientCredentialsGrantException::CLIENT_INACTIVE))
				->setField('client_id', 'client_secret')
				->setResponseCode(403);
		}

		$this->setClient($client);

		return $client;
	}

	/**
	 * Start the authorization based on the request parameters
	 */
	public function startAuthorization() {

		$grantType = $this->request->getPost('grant_type');

		if(!$grantType) {
			$grantType = $this->request->getQuery('grant_type');
		}

		$grantType = $this->getGrantType($grantType);

		$client = $this->validateClientCredentials();

		$grantType->authorize();
	}

	/**
	 * Set client
	 */
	public function setClient(ClientInterface $client): self {
		$this->_client = $client;

		return $this;
	}

	/**
	 * Get client
	 */
	public function getClient(): ClientInterface {
		return $this->_client;
	}

	/**
	 * Get client ID
	 */
	public function getClientId(): int {
		return $this->getClient()->getId();
	}

	/**
	 * Set user
	 */
	public function setUser($user): self {
		$this->_user = $user;

		return $this;
	}

	/**
	 * Get user
	 */
	public function getUser() {
		return $this->_user;
	}

	/**
	 * Get user ID
	 */
	public function getUserId(): int {
		return $this->getUser()->getId();
	}

	/**
	 * List of valid storage models
	 */
	protected function getStorageModelIdentifiers(): array {
		return [
			'Client',
			'ClientEndpoint',
			'ClientGrant',
			'ClientScope',
			'GrantScope',
		];
	}

/* MAGIC */
	public function __call($name, $arg = []) {
		//if($this->_auth instanceof UserAccessToken) {
		//	return call_user_func_array([$this->_auth, $name], $arg);
		//}

		if(substr($name, 0, 10) == 'getStorage') {
			return call_user_func([$this, 'getStorageModel'], substr($name, 10), ...$arg);
		}

		if(substr($name, 0, 10) == 'setStorage') {
			return call_user_func([$this, 'setStorageModel'], substr($name, 10), ...$arg);
		}

		throw new OAuthException('Method `'.$name.'` does not exists on library `'.get_class($this).'`');
	}
}
