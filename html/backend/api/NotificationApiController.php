<?php
declare (strict_types=1);
namespace backend\api;

require_once 'backend/services/TeacherNotificationService.php';
require_once 'backend/services/AlertSystemService.php';
require_once 'backend/services/NotificationSessionService.php';

use backend\services\NotificationSessionService;
use backend\services\TeacherNotificationService;
use backend\services\AlertSystemService;

class NotificationApiController{
    /**
     * @var AlertSystemService $alertService;
     */
    private $alertService;

    public function __construct() {
        $this->alertService = new AlertSystemService();
    }

    public function markAsViewed($request) {
        $memberId = NotificationSessionService::getMemberId();
        error_log($request);
        return;
        $alertId = (int)$request->alertId;
        $viewedAt = $request->viewedAt;
        $this->alertService->markAsViewed($alertId, $viewedAt, $memberId);
    }


    public function getUserNotifications () {
        return TeacherNotificationService::getNotifications();
    }
    public function setResource($resource) {
        $this->resource = $resource;
    }
}
