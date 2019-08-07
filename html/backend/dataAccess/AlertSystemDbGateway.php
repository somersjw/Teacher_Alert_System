<?php
declare(strict_types=1);
namespace backend\dataAccess;

require_once 'backend/dataAccess/DataManager.php';

use backend\dataAccess\DataManager;

class AlertSystemDbGateway {
    private $alertDm;

    public function __construct() {
        $this->alertDm = new DataManager();
    }

    public function getSites() {
        $query = "SELECT site_id, name
                  FROM site";
        $this->alertDm->query($query);
        return $this->alertDm->fetchAll();
    }

    public function getAlertById(int $alertId) {
        $query = "SELECT alert_id, alert_title, alert_message, display_on, remove_on
                  FROM alert
                  WHERE alert_id = $alertId";
        $this->alertDm->query($query);
        return $this->alertDm->fetch();
    }

    public function insertAlert (string $alertTitle, string $alertMessage, string $displayOn, string $removeOn) {
        $query = "INSERT INTO alert
                    (alert_title, alert_message, display_on, remove_on, created_at)
                  VALUES ('$alertTitle', '$alertMessage', '$displayOn', '$removeOn', NOW())";

        $this->alertDm->query($query);

        return $this->alertDm->lastId();
    }

    public function insertIntoAlertSites(int $alertId, int $siteId) {
        $query = "INSERT INTO alert_site
                    (alert_id, site_id)
                  VALUES ($alertId, $siteId)";

        $this->alertDm->query($query);
        return $this->alertDm->rowsAffected();
    }

    public function updateAlert(int $alertId, string $alertTitle, string $alertMessage, string $displayOn, string $removeOn) {
        $query = "UPDATE alert
                    SET alert_title = '$alertTitle', alert_message = '$alertMessage',
                        display_on = '$displayOn', remove_on = '$removeOn'
                  WHERE alert_id = $alertId";

        $this->alertDm->query($query);
    }

    public function deleteAlert(int $alertId) {
        $query = "DELETE
                  FROM alert
                  WHERE alert_id = $alertId";

        $this->alertDm->query($query);
        return $this->alertDm->rowsAffected();
    }

    public function deleteAlertSiteAssociations(int $alertId) {
        $query = "DELETE
                  FROM alert_site
                  WHERE alert_id = $alertId";

        $this->alertDm->query($query);
    }

    public function deleteAlertMemberActivity(int $alertId) {
        $query = "DELETE
                  FROM alert_member_activity
                  WHERE alert_id = $alertId";

        $this->alertDm->query($query);
    }

    public function getPendingAlerts() {
        // TODO: include display_on > NOW() in where clause for prod
        $query = "SELECT alert_id, alert_title, alert_message, display_on, remove_on
                  FROM alert
                  WHERE 1
                  ORDER BY alert_id DESC";

        $this->alertDm->query($query);
        return $this->alertDm->fetchAll();
    }

    public function getAlertSites(int $alertId) {
        $query = "SELECT alert_site.site_id, site.name
                  FROM alert_site, site
                  WHERE alert_site.alert_id = $alertId
                  AND alert_site.site_id = site.site_id";

        $this->alertDm->query($query);
        return $this->alertDm->fetchAll();
    }

    public function getUserNotifications($siteList, $memberId) {
        // TODO: include display_on < NOW() in where clause for prod
        $query = "SELECT distinct alert.alert_id, alert.alert_title, alert.alert_message, alert.display_on, alert.remove_on, act.viewed_at
                    FROM alert
                    JOIN alert_site ON alert.alert_id = alert_site.alert_id                  
                    LEFT JOIN ( 
                    SELECT alert_id, viewed_at
                    FROM alert_member_activity 
                    WHERE member_id = $memberId
                    ) as act on act.alert_id = alert.alert_id
                    WHERE alert.remove_on > NOW()
                    AND alert_site.site_id IN ($siteList)  
            ORDER BY act.viewed_at  ASC";

        $this->alertDm->query($query);
        return $this->alertDm->fetchAll();
    }


    public function getUserUnreadNotificationCount($siteList, $memberId) {
        // TODO: include display_on < NOW() in where clause for prod
        $query = "SELECT COUNT(DISTINCT (alert.alert_id)) AS unseenCount
                  FROM alert
                    JOIN alert_site ON alert.alert_id = alert_site.alert_id                  
                    LEFT JOIN ( 
                    SELECT alert_id, viewed_at
                    FROM alert_member_activity 
                    WHERE member_id = $memberId
                    ) as act on act.alert_id = alert.alert_id
                    WHERE alert.remove_on > NOW()
                    AND act.viewed_at IS NULL
                    AND alert_site.site_id IN ($siteList)";

        $this->alertDm->query($query);
        return $this->alertDm->fetch();
    }

    public function markAsViewed(int $alertId, int $memberId, $viewedAt) {
        $query = "INSERT INTO alert_member_activity
                    (alert_id, member_id, viewed_at)
                  VALUES ($alertId, $memberId, '$viewedAt')";

        $this->alertDm->query($query);
    }
}