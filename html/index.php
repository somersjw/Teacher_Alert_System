<?php
session_start();
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';
require_once 'backend/api/AlertSystemApiController.php';
require_once 'backend/api/NotificationApiController.php';

use objects\library\Router\Request;
use objects\library\Router\Router;
use backend\api\AlertSystemApiController;
use backend\api\NotificationApiController;

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

$router->get('/api/alert-system/sites', function() {
	$apiController = new AlertSystemApiController();
	return $apiController->getSites();
	echo 'ddd';
});

$router->get('/api/notifications/messages', function() {
	$apiController = new NotificationApiController();
	return $apiController->getUserNotifications();
	echo 'yay';
});

$router->post('/selectUser', function() {
	$username = explode('*', $_POST["user"])[0];
	$id = (int)explode('*', $_POST["user"])[1];

	$_SESSION["user"] = array("name" => $username, "member_id" => $id);
	header('Location: /teacher');
});