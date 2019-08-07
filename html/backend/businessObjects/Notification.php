<?php
namespace backend\businessObjects;

class Notification {
    public $alertId;
    public $alertTitle;
    public $alertMessage;
    public $displayOn;
    public $viewedAt;

    public function __construct($alertId, $alertTitle, $alertMessage, $displayOn, $viewedAt) {
        $this->alertId = $alertId;
        $this->alertTitle = $alertTitle;
        $this->alertMessage = $alertMessage;
        $this->displayOn = $displayOn;
        $this->viewedAt = $viewedAt;
    }

    private static function fromArray($arr) {
        return new Notification(
            $arr['alert_id'],
            $arr['alert_title'],
            $arr['alert_message'],
            $arr['display_on'],
            $arr['viewed_at']
        );
    }

    public static function fromArrays($arrays, $unseenCount) {
        $notificationList["notifications"] = array_map(function ($arr) {
            return Notification::fromArray($arr);
        }, $arrays);

        $notificationList["unseenCount"] = $unseenCount;
        return $notificationList;
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

    public function getViewedAt() {
        return $this->viewedAt;
    }

    public function setViewedAt($viewedAt) {
        $this->viewedAt = $viewedAt;
    }
}