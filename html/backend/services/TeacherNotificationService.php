<?php
namespace LAZ\objects\admin2\alertSystem\services;

class TeacherNotificationService {
    static public function getNotifications() {
        $notifications = NotificationSessionService::getNotifications();
        if ($notifications == null) {
            $alertService = new AlertSystemService();
            $siteList = NotificationSessionService::getUserSubscriptionSiteList();
            $notifications = $alertService->getUserNotifications($siteList);
            NotificationSessionService::setNotifications($notifications);
        }
        return $notifications;
    }
}