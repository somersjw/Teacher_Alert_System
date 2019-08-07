<?php
namespace backend\services;
require_once 'backend/services/NotificationSessionService.php';
require_once 'backend/services/AlertSystemService.php';

use backend\services\NotificationSessionService;
use backend\services\AlertSystemService;

class TeacherNotificationService {
    static public function getNotifications() {
        $notifications = NotificationSessionService::getNotifications();
        if ($notifications == null) {
            $alertService = new AlertSystemService();
            $siteList = NotificationSessionService::getUserSubscriptionSiteList();
            $notifications = $alertService->getUserNotifications($siteList, (int)$_SESSION["user"]["id"]);
            NotificationSessionService::setNotifications($notifications);
        }
        return $notifications;
    }
}