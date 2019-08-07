<?php
declare(strict_types=1);
namespace backend\services;

require_once 'backend/businessObjects/Notification.php';

use backend\businessObjects\Notification;
// use LAZ\objects\library\SiteHelper;

class NotificationSessionService {
    static public function getNotifications() {
        return $_SESSION['notificationInfo'];
    }

    static public function setNotifications($notifications) {
        $_SESSION['notificationInfo'] = $notifications;
    }

    static public function markSessionAlertAsViewed(int $viewedAlertId, $dateTime) {
        /**
         * @var  Notification $alert
         */
        foreach($_SESSION['notificationInfo']['notifications'] as $index=>$alert) {
            if ($viewedAlertId == $alert->getAlertId()) {
                $alert->setViewedAt($dateTime);
                $_SESSION['notificationInfo']['unseenCount']--;
                break;
            }
        }
    }

    static public function getUserSubscriptionSiteList() {
        // NOTE: This is a stub without adding the entire system of tracking user subscriptions
        switch((int)$_SESSION["user"]["id"]) {
            case 1:
                return '2';
                break;
            
            case 2:
                return '5';
                break;

            case 3:
                return '2, 5';
                break;
        }

        // $siteList = "";

        // if ($_SESSION['has_rk_sub']) {
        //     $siteList = $siteList . SiteHelper::RK_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_raz_sub']) {
        //     $siteList = $siteList . SiteHelper::RAZ_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_vocab_sub']) {
        //     $siteList = $siteList . SiteHelper::VAZ_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_waz_sub']) {
        //     $siteList = $siteList . SiteHelper::WAZ_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_saz_sub']) {
        //     $siteList = $siteList . SiteHelper::SAZ_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_raz_ell_sub']) {
        //     $siteList = $siteList . SiteHelper::RAZ_ELL_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_headsprout_sub']) {
        //     $siteList = $siteList . SiteHelper::HEADSPROUT_SITE_ID . ", ";
        // }

        // if ($_SESSION['has_raz_sub'] && $_SESSION['has_rk_sub']) {
        //     $siteList = $siteList . SiteHelper::RAZ_PLUS_SITE_ID . ", ";
        // }

        // return rtrim($siteList,", ");
    }
}