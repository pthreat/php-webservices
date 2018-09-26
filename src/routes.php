<?php

use Slim\Http\Request;
use Slim\Http\Response;

use \webservices\orm\UserQuery;

// Login

$app->post('/auth/login', function (Request $req, Response $res, array $args){

	if($this->session->get('user')){
		return $res->withStatus(409)
		->withJson([
			'message'=>'Please logout first'
		]);
		return $res;
	}

	$user = UserQuery::create()
	->where('User.Email = ?', $req->getParam('email'))
	->findOne();

	if(null === $user){
		return $res->withStatus(403)
		->withJSON([
			'message' => 'Login failure'
		]);
	}

	$valid = password_verify($req->getParam('password'), $user->getPassword());

	if(false === $valid){
		return $res->withStatus(403)
		->withJSON([
			'message' => 'Login failure'
		]);
	}

	$this->session->set('user', $user->getId());
	$this->logger->info("User {$user->getEmail()} logged in");

	$data = array_change_key_case($user->toArray());
	unset($data['password']);
	return $res->withJSON($data);
});

//Check whoami once I'm logged in
$app->get('/auth/whoami', function(Request $req, Response $res, array $args){

	if(null === $this->user){
		return $res->withStatus(409)
		->withJSON([
			'message' => 'Please login first'
		]);
	}

	$data = array_change_key_case($this->user->toArray());

	unset($data['password']);

	return $res->withJSON($data);
});

//Logout
$app->get('/auth/logout', function (Request $req, Response $res, array $args){

	if(null === $this->user){
		return $res->withStatus(409)
		->withJson([
			'success' => false,
			'message' => 'Please login first'
		]);
	}

	$this->logger->info("User {$this->user->getEmail()} logged out");
	$this->session->destroy();

	return $res->withJson([
		'success'=>true
	]);

});
