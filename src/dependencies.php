<?php
// DIC configuration

use Odan\Slim\Session\Session;
use Odan\Slim\Session\Adapter\PhpSessionAdapter;

use \webservices\orm\UserQuery;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) use($app){
    $settings = $c->get('config')['settings']['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$container['session'] = function($c){
   $settings = $c->get('config')['settings']['session'];
	$session = new Session(new PhpSessionAdapter());
	$session->setOptions($settings);
	$session->start();
	return $session;
};

$container['user'] = function($c){
	$session = $c->get('session');
	$user = $session->get('user');

	if(!$c->get('session')->get('user')){
		return null;
	}

	return UserQuery::create()
	->where('User.Id = ?', $session->get('user'))
	->findOne();
};
