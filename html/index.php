<?php
session_start();
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';

use objects\library\Router\Request;
use objects\library\Router\Router;

if (!array_key_exists("user", $_SESSION)) {
	$_SESSION["user"] = array("name" => "ReaderDude", "member_id" => 1); 
}


$request = new Request();
$router = new Router($request);

include 'include.html';
include 'navbar.html';

$router->get('/', function () {
	
	include 'index.html';
});

$router->get('/teacher', function() {
    include 'teacher.html';
});

$router->get('/manage', function() {
    include 'manage.html';
});

$router->post('/selectUser', function() {
	$username = explode('*', $_POST["user"])[0];
	$id = (int)explode('*', $_POST["user"])[1];

	$_SESSION["user"] = array("name" => $username, "member_id" => $id);
	header('Location: /teacher');
});
