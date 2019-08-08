<?php
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';
require_once 'backend/api/AlertSystemApiController.php';
require_once 'backend/api/NotificationApiController.php';
require_once 'backend/businessObjects/Notification.php';
require_once 'backend/dataAccess/DataManager.php';

session_start();

use objects\library\Router\Request;
use objects\library\Router\Router;
use backend\api\AlertSystemApiController;
use backend\api\NotificationApiController;
use backend\dataAccess\DataManager;

if (!array_key_exists("user", $_SESSION)) {
	$_SESSION["user"] = array("name" => "ReaderDude", "member_id" => 1); 
}


$request = new Request();
$router = new Router($request);

$router->get('/', function () {
	include 'include.html';
    include 'navbar.html';
	include 'index.html';
});

$router->get('/teacher', function() {
	include 'include.html';
    include 'navbar.html';
    include 'teacher.html';
});

$router->get('/manage', function() {
	include 'include.html';
    include 'navbar.html';
	include 'manage.html';
	echo 'ddd';
});

$router->get('/api/alert-system/sites', function() {
	$apiController = new AlertSystemApiController();
	return json_encode( $apiController->getSites());
});

$router->get('/api/alert-system/pending', function() {
	$apiController = new AlertSystemApiController();
	return json_encode($apiController->getPendingAlerts());
});

$router->get('/api/notifications/messages', function() {
	$apiController = new NotificationApiController();
	return json_encode($apiController->getUserNotifications());
});

$router->post('/api/notifications/viewed', function() {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	$apiController = new NotificationApiController();
	return json_encode($apiController->markAsViewed($request));
});

$router->post('/selectUser', function() {
	if (array_key_exists("user", $_SESSION)) {
		session_destroy();
	}
	session_start();
	$username = explode('*', $_POST["user"])[0];
	$id = (int)explode('*', $_POST["user"])[1];

	$_SESSION["user"] = array("name" => $username, "member_id" => $id);
	header('Location: /teacher');
});

$router->post('/resetDemo', function() {
	if (array_key_exists("user", $_SESSION)) {
		session_destroy();
	}
	session_start();
	$_SESSION["user"] = array("name" => "ReaderDude", "member_id" => 1); 

	$dm = new DataManager();
	$dm->resetDb();

	header('Location: /teacher');
});

$router->delete('/api/alert-system/alert', function() {
	$apiController = new AlertSystemApiController();
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	error_log(print_r($request, true));
	// return json_encode($apiController->deleteAlert((int)$alertId));
});