<?php
require_once 'objects/library/Router/Request.php';
require_once 'objects/library/Router/Router.php';
require_once 'objects/library/Router/AltoRouter.php';
require_once 'backend/api/AlertSystemApiController.php';
require_once 'backend/api/NotificationApiController.php';
require_once 'backend/businessObjects/Notification.php';
require_once 'backend/dataAccess/DataManager.php';

session_start();

use objects\library\Router\Request;
use objects\library\Router\Router;
use objects\library\Router\AltoRouter;
use backend\api\AlertSystemApiController;
use backend\api\NotificationApiController;
use backend\dataAccess\DataManager;

if (!array_key_exists("user", $_SESSION)) {
	$_SESSION["user"] = array("name" => "ReaderDude", "member_id" => 1); 
}


// $request = new Request();
// $router = new Router($request);

$router = new AltoRouter();


$router->map('GET', '/', function() {
	include 'include.html';
    include 'navbar.html';
	include 'index.html';
});

$router->map('GET', '/teacher', function() {
		include 'include.html';
	    include 'navbar.html';
	    include 'teacher.html';
});

$router->map('GET', '/manage', function() {
	include 'include.html';
    include 'navbar.html';
	include 'manage.html';
});

$router->map('GET', '/api/alert-system/sites', function() {
	$apiController = new AlertSystemApiController();
	echo json_encode( $apiController->getSites());
});

$router->map('GET', '/api/alert-system/pending', function() {
	$apiController = new AlertSystemApiController();
	return json_encode($apiController->getPendingAlerts());
});

$router->map('GET', '/api/notifications/messages', function() {
	$apiController = new NotificationApiController();
	return json_encode($apiController->getUserNotifications());
});

$router->map('POST','/api/notifications/viewed', function() {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	$apiController = new NotificationApiController();
	return json_encode($apiController->markAsViewed($request));
});


$router->map('POST', '/selectUser', function() {
	if (array_key_exists("user", $_SESSION)) {
		session_destroy();
	}
	session_start();
	$username = explode('*', $_POST["user"])[0];
	$id = (int)explode('*', $_POST["user"])[1];

	$_SESSION["user"] = array("name" => $username, "member_id" => $id);
	header('Location: /teacher');
});

$router->map('POST', '/resetDemo', function() {
	if (array_key_exists("user", $_SESSION)) {
		session_destroy();
	}
	session_start();
	$_SESSION["user"] = array("name" => "ReaderDude", "member_id" => 1); 

	$dm = new DataManager();
	$dm->resetDb();

	header('Location: /teacher');
});

$router->map('DELETE', '/api/alert-system/alert/[i:id]', function($id) {
	$apiController = new AlertSystemApiController();
	$alertId = (int)$id;
	return json_encode($apiController->deleteAlert($alertId));
});

$router->map('GET', '/api/alert-system/alert/[i:id]', function($id) {
	$apiController = new AlertSystemApiController();
	$alertId = (int)$id;
	return json_encode($apiController->getAlertById($alertId));
});


$router->map('POST', '/api/alert-system/alert', function() {
	$apiController = new AlertSystemApiController();
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	return json_encode($apiController->createAlert($request));
});

$router->map('PATCH', '/api/alert-system/editalert', function() {
	$apiController = new AlertSystemApiController();
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	return json_encode($apiController->editAlert($request));
});

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
