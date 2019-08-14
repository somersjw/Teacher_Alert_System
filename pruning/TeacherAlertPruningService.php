<?php

namespace LAZ\objects\tools;

class TeacherAlertPruningService {

    /**
     * @var TeacherAlertPruningDbGateway
     * @var Logger
     */
    private $notificationGateway;
    private $logger;
    public function __construct() {
        $this->notificationGateway = new TeacherAlertPruningDbGateway();
        $this->logger = new Logger(__CLASS__);
    }

    public function pruneAlerts() {
        $pruneDate = $this->getCutoffDateForPruning();
        $this->logger->logInfo("Pruning alerts that expired before '$pruneDate'");
        $alertsToPrune = $this->notificationGateway->getAlertsToPrune($pruneDate);
        $this->logger->logInfo(sizeof($alertsToPrune) . " alerts will be pruned.");
        $this->deleteAlertInfo($alertsToPrune);
        $this->logger->logInfo("Alerts were successfully pruned.");
    }

    private function deleteAlertInfo($alertsToPrune) {
        foreach ($alertsToPrune as $alert) {
            $alertId = $alert['alert_id'];

            $this->logger->logInfo("Pruning alert_site where alert_id = $alertId");
            $this->notificationGateway->deleteAlertSite($alertId);

            $this->logger->logInfo("Pruning alert_member_activity where alert_id = $alertId");
            $this->notificationGateway->deleteAlertActivity($alertId);

            $this->logger->logInfo("Pruning alert where alert_id = $alertId");
            $this->notificationGateway->deleteAlert($alertId);
        }
    }

    private function getCutoffDateForPruning() {
        return date('Y-m-d', strtotime('-90 days'));
    }
}