<?php
declare(strict_types=1);

class Alert {
    public $alertId;
    public $alertTitle;
    public $alertMessage;
    public $displayOn;
    public $removeOn;
    public $alertSites;
    public $sites;

    public function __construct(int $alertId = null, string $alertTitle, string $alertMessage, string $displayOn, string $removeOn, $sites) {
        $this->alertId = $alertId;
        $this->alertTitle = $alertTitle;
        $this->alertMessage = $alertMessage;
        $this->displayOn = $displayOn;
        $this->removeOn = $removeOn;
        $this->alertSites = $this->getSitesCSV($sites);
        $this->sites = AlertSite::fromArraysForEdit($sites);
    }

    private function getSitesCSV($sites) {
        $sitesCSV = "";
        foreach($sites as $site) {
            $sitesCSV = $sitesCSV . $site['name'] . ", ";
        }

        return rtrim($sitesCSV,", ");
    }

    public static function fromArray($arr) {
        if (array_key_exists('alert_id', $arr)) {
            // getPendingAlerts
            return new Alert(
                (int)$arr['alert_id'],
                $arr['alert_title'],
                $arr['alert_message'],
                $arr['display_on'],
                $arr['remove_on'],
                $arr['sites']);
        }
        else if (!array_key_exists('alertId', $arr)) {
            return new Alert(
                null,
                $arr['alertTitle'],
                $arr['alertMessage'],
                $arr['displayOn'],
                $arr['removeOn'],
                $arr['sites']);
        }
        // editAlert
        return new Alert(
            (int)$arr['alertId'],
            $arr['alertTitle'],
            $arr['alertMessage'],
            $arr['displayOn'],
            $arr['removeOn'],
            $arr['sites']);
    }

    public static function fromArrays($arrays) {
        return array_map(function ($arr) {
            return Alert::fromArray($arr);
        }, $arrays);
    }

    public function getAlertId() {
        return $this->alertId;
    }

    public function getAlertTitle() {
        return $this->alertTitle;
    }

    public function getAlertMessage() {
        return $this->alertMessage;
    }

    public function getDisplayOn() {
        return $this->displayOn;
    }

    public function getRemoveOn() {
        return $this->removeOn;
    }

    public function getAlertSites() {
        return $this->alertSites;
    }

    public function getSites() {
        return $this->sites;
    }
}
