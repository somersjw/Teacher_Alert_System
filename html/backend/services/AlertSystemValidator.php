<?php
namespace LAZ\objects\admin2\alertSystem\services;

use LAZ\objects\admin2\alertSystem\businessObjects\Alert;
use LAZ\objects\library\FormHelpers;

class AlertSystemValidator {
    const MAX_ALERT_TITLE_LENGTH = 50;
    const MIN_ALERT_TITLE_LENGTH = 5;
    const MAX_ALERT_MESSAGE_LENGTH = 255;
    /**
     * @param Alert $alert;
     */
   static public function validateAlert($alert) {
        if (!AlertSystemValidator::isAlertTitleValid($alert->getAlertTitle())) {
            throw new \InvalidArgumentException("Title must be between " . self::MIN_ALERT_TITLE_LENGTH . " and " . self::MAX_ALERT_TITLE_LENGTH . " characters.");
        }

        if (!AlertSystemValidator::isAlertMessageValid($alert->getAlertMessage())) {
            throw new \InvalidArgumentException("Message must be " . self::MAX_ALERT_MESSAGE_LENGTH . " characters or less.");
        }

        if (!AlertSystemValidator::isDisplayOnValid($alert->getDisplayOn())) {
            throw new \InvalidArgumentException("Display date must be tomorrow or later.");
        }

        if (!AlertSystemValidator::isRemoveOnValid($alert->getRemoveOn())) {
            throw new \InvalidArgumentException("Remove date must be a valid date.");
        }

        if (!AlertSystemValidator::isDisplayOnBeforeRemoveOn($alert->getDisplayOn(), $alert->getRemoveOn())) {
            throw new \InvalidArgumentException("Remove date must be past the Display date");
        }

        if (!AlertSystemValidator::areSitesSelected($alert->getSites())) {
            throw new \InvalidArgumentException("Select at least one site.");
        }
    }

    static private function isAlertTitleValid($alertTitle) {
        return strlen($alertTitle) <= self::MAX_ALERT_TITLE_LENGTH && strlen($alertTitle) >= self::MIN_ALERT_TITLE_LENGTH;
    }

    static private function isAlertMessageValid($alertMessage) {
        return strlen($alertMessage) <= self::MAX_ALERT_MESSAGE_LENGTH && $alertMessage != null;
    }

    static private function isDisplayOnValid($displayOn) {
       $formHelper = new FormHelpers();
        return $formHelper->isSQLDate($displayOn) && $displayOn > date('Y-m-d');
    }

    static private function isRemoveOnValid($removeOn) {
        $formHelper = new FormHelpers();
        return $formHelper->isSQLDate($removeOn);
    }

    static private function isDisplayOnBeforeRemoveOn($displayOn, $removeOn) {
        return $displayOn < $removeOn;
    }

    static private function areSitesSelected($sites) {
        return sizeof($sites);
    }
}