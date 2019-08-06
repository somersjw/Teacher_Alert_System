<?php
declare(strict_types=1);
namespace backend\services;

use LAZ\objects\library\FormHelpers;
use LAZ\objects\library\SiteHelper;
use LAZ\objects\admin2\alertSystem\businessObjects\Alert;
use backend\AlertSystemDbGateway;
use LAZ\objects\shared\businessObjects\AlertSystem\Notification;

class AlertSystemService {
    /**
     * @var	AlertSystemDbGateway
     */
    private $alertGateway;

    public function __construct() {
        $this->alertGateway = new AlertSystemDbGateway();
    }

    public function getSites() {
        return AlertSite::fromArraysForCreate($this->alertGateway->getSites());
    }

    public function createAlert($alert) {
        $alert = $this->formatAlertForSQL($alert);
        AlertSystemValidator::validateAlert(Alert::fromArray($alert));
        $alertId = $this->alertGateway->insertAlert($alert['alertTitle'], $alert['alertMessage'], $alert['displayOn'], $alert['removeOn']);
        $this->insertAlertSiteAssociations($alert, $alertId);
        return $alertId;
    }

    public function getAlertById(int $alertId) {
        $alert = $this->alertGateway->getAlertById($alertId);
        $alert['sites'] = $this->alertGateway->getAlertSites($alertId);
        return Alert::fromArray($alert);
    }

    public function deleteAlert(int $alertId) {
        $this->alertGateway->deleteAlertSiteAssociations($alertId);
        $this->alertGateway->deleteAlertMemberActivity($alertId);
        return $this->alertGateway->deleteAlert($alertId);
    }

    public function editAlert($alert) {
        $alert = $this->formatAlertForSQL($alert);

        $this->alertGateway->updateAlert($alert['alertId'], $alert['alertTitle'], $alert['alertMessage'], $alert['displayOn'], $alert['removeOn']);
        $this->alertGateway->deleteAlertSiteAssociations($alert['alertId']);
        $this->insertAlertSiteAssociations($alert, $alert['alertId']);

        return Alert::fromArray($alert);
    }

    public function getPendingAlerts() {
        $alerts = $this->alertGateway->getPendingAlerts();
        foreach($alerts as $index => $alert) {
            $alerts[$index]['sites'] = $this->alertGateway->getAlertSites((int)$alert['alert_id']);
        }
        return Alert::fromArrays($alerts);
    }

    public function getUserNotifications($siteList) {
        $unseenCount = $this->alertGateway->getUserUnreadNotificationCount($siteList);
        $alerts = $this->alertGateway->getUserNotifications($siteList);
        return Notification::fromArrays($alerts, $unseenCount["unseenCount"]);
    }

    public function markAsViewed(int $alertId, $viewedAt, int $memberId) {
        $this->alertGateway->markAsViewed($alertId, $memberId, $viewedAt);
        //NotificationSessionService::markSessionAlertAsViewed($alertId, $viewedAt);
    }

    private function insertAlertSiteAssociations($alert, int $alertId) {
        foreach($alert['sites'] as $site) {
            $this->alertGateway->insertIntoAlertSites($alertId, $site['siteId']);
        }
    }

    private function formatAlertForSQL($alert) {
        $alert['alertTitle'] = FormHelpers::checkAddSlashes($alert['alertTitle']);
        $alert['alertMessage'] = FormHelpers::checkAddSlashes($alert['alertMessage']);
        $alert['displayOn'] = explode("T", $alert['displayOn'])[0];
        $alert['removeOn'] = explode("T", $alert['removeOn'])[0];
        if (array_key_exists('alertId', $alert)) {
            $alert['alertId'] = (int)$alert['alertId'];
        }
        return $alert;
    }
}