<?php

use Phalcon\Mvc\Application,
	Phalcon\Mvc\View,
	Phalcon\Mvc\Dispatcher,
    Phalcon\Di,
    Phalcon\Di\FactoryDefault as DiFactoryDefault,
    Phalcon\Loader;

use FaimMedia\OAuth\Di\OAuth;

// define paths
	define('ROOT_PATH', realpath(__DIR__.'/..').'/');
	define('APP_PATH', ROOT_PATH.'app/');

// set DI
	$di = new DiFactoryDefault();

	Di::setDefault($di);

	$di->setShared('view', function() {
		return new View();
	});

	$di->setShared('dispatcher', function() use ($di) {
		$dispatcher = new Dispatcher();
		$dispatcher->setDefaultNamespace('Controller');
		$dispatcher->setControllerSuffix('');
		$dispatcher->setActionSuffix('Action');

		return $dispatcher;
	});

	// oauth server magic
		$di->setShared('oauth', function() use ($di) {

			$oauth = new OAuth();

		});

// auto loader
	if(file_exists(ROOT_PATH.'vendor/autoload.php')) {
		require ROOT_PATH.'vendor/autoload.php';
	}

	$loader = new Loader();

	$loader->registerNamespaces([
		'Controller'   => APP_PATH.'controller/',
		'Component'    => APP_PATH.'component/',
		'Helper'       => APP_PATH.'helper/',
		'Module'       => APP_PATH.'module/',
	]);

	$loader->registerDirs([
		APP_PATH.'model/',
	]);

	$loader->register();

// run app
	$app = new Application($di);

	echo $app->handle()->getContent();
