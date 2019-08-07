<?php
declare (strict_types=1);
namespace backend\api;

use backend\services\TeacherNotificationService;
use backend\services\AlertSystemService;
// use LAZ\objects\razkids\TeacherInfoCache;

class NotificationApiControlle{
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
