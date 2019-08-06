<?php
declare (strict_types=1);
namespace LAZ\objects\shared\api;

use LAZ\objects\admin2\alertSystem\services\TeacherNotificationService;
use LAZ\objects\library\Router\Resource;
use LAZ\objects\admin2\alertSystem\services\AlertSystemService;
use LAZ\objects\razkids\TeacherInfoCache;

class NotificationApiController implements Resource {
    /**
     * @var Resource $resource;
     * @var AlertSystemService $alertService;
     */
    private $resource;
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
