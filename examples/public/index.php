<?php

use Phalcon\Mvc\Application,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Config\Adapter\Json as Config,
    Phalcon\Db\Adapter\Pdo\Mysql,
    Phalcon\Di,
    Phalcon\Di\FactoryDefault as DiFactoryDefault,
    Phalcon\Loader,
    Phalcon\Events\Manager as EventsManager;

use Component\Event\DispatcherEvent;

/**
 * Use OAuth classes
 */
	use FaimMedia\OAuth\Di\OAuth;

	use Model\AccessToken,
	    Model\Client,
	    Model\ClientEndpoint,
	    Model\Session;

// define paths
	define('ROOT_PATH', realpath(__DIR__.'/..').'/');
	define('APP_PATH', ROOT_PATH.'app/');

// auto loader
	$vendorPath = realpath(dirname(ROOT_PATH, 4).'/vendor/autoload.php');
	if(file_exists($vendorPath)) {
		require $vendorPath;
	}

	$loader = new Loader();

	$loader->registerNamespaces([
		'Controller'   => APP_PATH.'controller/',
		'Component'    => APP_PATH.'component/',
		'Model'        => APP_PATH.'model/',
	]);

	$loader->register();

// set DI
	$di = new DiFactoryDefault();

	Di::setDefault($di);

	$di->setShared('view', function() {
		return new View();
	});

	$di->setShared('config', function() {
		return new Config(APP_PATH.'config/config.json');
	});

	$di->setShared('db', function() use ($di) {
		return new Mysql($di->getShared('config')->database->toArray());
	});

	$di->setShared('dispatcher', function() use ($di) {
		$dispatcher = new Dispatcher();
		$dispatcher->setDefaultNamespace('Controller');
		$dispatcher->setControllerSuffix('');
		$dispatcher->setActionSuffix('Action');

		$eventsManager = new EventsManager();
		$eventsManager->attach('dispatch', new DispatcherEvent());

		$dispatcher->setEventsManager($eventsManager);


		return $dispatcher;
	});

	// oauth server magic
		$di->setShared('oauth', function() use ($di) {

			$oauth = new OAuth();
			$oauth->setStorageAccessToken(new AccessToken());
			$oauth->setStorageClient(new Client());
			$oauth->setStorageClientEndpoint(new ClientEndpoint());
			$oauth->setStorageSession(new Session());

			return $oauth;
		});

// run app
	$app = new Application($di);

	echo $app->handle()->getContent();
