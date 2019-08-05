<?php
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';

use objects\library\Router\Request;
use objects\library\Router\Router;

$request = new Request();
$router = new Router($request);
include 'navbar.html';

$router->get('/', function () {
	include 'include.html';
	include 'index.html';
});

$router->get('/teacher', function() {
    include 'teacher.html';
});

$router->get('/manage', function() {
    include 'manage.html';
});

$router->post('/selectUser', function() {
	session_start();
	$_SESSION["user"] = $_POST["user"];
	header('Location: /teacher');
});
