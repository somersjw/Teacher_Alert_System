<?php
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';

use objects\library\Router\Request;
use objects\library\Router\Router;

$request = new Request();
$router = new Router($request);

$router->get('/', function () {
	//include 'include.html';
	include 'index.html';
});

$router->get('/teacher', function() {
	//include 'teacher.html';
	echo 'test';
});
