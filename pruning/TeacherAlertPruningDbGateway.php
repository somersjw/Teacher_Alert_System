<?php

namespace LAZ\objects\tools;

use LAZ\objects\data\DataManager;
use LAZ\objects\tools\BatchInsertValuesManager;
class TeacherAlertPruningDbGateway {

    /*
     * @var DataManager
     */

    private $alertDm;
    public function __construct() {
        $this->alertDm = new DataManager(DataManager::DB_ACCOUNTS, DataManager::LOC_MASTER);
    }

    public function getAlertsToPrune ($pruneDate) {
        $alertDm = $this->getDataManager();

        $query = "SELECT alert_id
                  FROM alert
                  WHERE remove_on < '$pruneDate'";

        $alertDm->query($query);
        $results = $alertDm->fetchAll();
        return $results;
    }

    public function deleteAlertSite ($alertId) {
        $alertDm = $this->getDataManager();

        $query = "DELETE
                  FROM alert_member_activity
                  WHERE alert_id = $alertId";

        $alertDm->query($query);
    }

    public function deleteAlertActivity ($alertId) {
        $alertDm = $this->getDataManager();

        $query = "DELETE
                  FROM alert_member_activity
                  WHERE alert_id = $alertId";

        $alertDm->query($query);
    }

    public function deleteAlert ($alertId) {
        $alertDm = $this->getDataManager();

        $query = "DELETE
                  FROM alert
                  WHERE alert_id = $alertId";

        $alertDm->query($query);
    }

    private function getDataManager() {
        if ($this->alertDm == null){
            $this->alertDm = new DataManager(DataManager::DB_ACCOUNTS, DataManager::LOC_MASTER);
        }
        return $this->alertDm;
    }
}