<?php
declare (strict_types=1);
namespace backend\api;

require_once 'backend/services/TeacherNotificationService.php';
require_once 'backend/services/AlertSystemService.php';

use backend\services\TeacherNotificationService;
use backend\services\AlertSystemService;
// use LAZ\objects\razkids\TeacherInfoCache;

class NotificationApiController{
    /**
     * @var AlertSystemService $alertService;
     */
    private $alertService;

    public function __construct() {
        $this->alertService = new AlertSystemService();
    }

    public function markAsViewed() {
        $memberId = (int)TeacherInfoCache::getTeacherId();
        $notification = $this->resource;
        $alertId = (int)$notification['alertId'];
        $viewedAt = $notification['viewedAt'];
        $this->alertService->markAsViewed($alertId, $viewedAt, $memberId);
    }


    public function getUserNotifications () {
        return TeacherNotificationService::getNotifications();
    }
    public function setResource($resource) {
        $this->resource = $resource;
    }
}
