<?php
return [
	'settings' => [
		'displayErrorDetails' => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header
		// Monolog settings
		'logger' => [
			'name' => 'webservices',
			'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
			'level' => \Monolog\Logger::DEBUG,
		],
		'session' => [
			'name' => 'REST_API',
		]
	],
];