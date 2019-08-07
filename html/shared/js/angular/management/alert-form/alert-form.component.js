(function () {
    "use strict";

    angular.module("AlertSystem")
        .component("alertForm", {
            templateUrl: "shared/js/angular/management/alert-form/alert-form.html",
            controller: "AlertFormCtrl",
            bindings: {
                alertId: '<?',
                formName: '<'
            }
        })
        .controller("AlertFormCtrl", ["alertDataLayer", "alertSystemSubmissionHandler",
            function AlertController(alertDataLayer, alertSystemSubmissionHandler) {
                var ctrl = this;
                ctrl.max = 50;
                var getTomorrowsDate = function () {
                    var today = new Date();
                    return new Date(today.getTime() + (24 * 60 * 60 * 1000));
                };

                var getJSDateFromDateString = function (dateString) {
                    return new Date(dateString.concat("T12:00:00"));
                };

                var setAlertFields = function (response) {
                    ctrl.alert = angular.copy(response.data);
                    ctrl.alert.displayOn = getJSDateFromDateString(ctrl.alert.displayOn);
                    ctrl.setRemoveOnMinDate(ctrl.alert.displayOn);
                    ctrl.alert.removeOn = getJSDateFromDateString(response.data.removeOn);
                    ctrl.siteList = ctrl.alert.sites;
                };

                var initializeAlertFromId = function (alertId) {
                    if (!alertId) {
                        ctrl.alert = {};
                        initializeSiteList();
                    }
                    else {
                        alertDataLayer.getAlert(alertId)
                            .then(setAlertFields);
                    }
                };

                var initializeSiteList  = function () {
                    alertDataLayer.getSiteList()
                        .then(function (data) {
                            ctrl.siteList = data;
                        });
                };

                var resetForm = function () {
                    ctrl.alert = {};
                    setSiteListSelectedValues(false);
                    ctrl.isSelectAllChecked = false;
                    ctrl.formName.$setUntouched();
                    ctrl.formName.$setPristine();
                };

                var submitCallback = function () {
                    alertSystemSubmissionHandler.publishSubmission("submit", ctrl.alert.alertId);
                    resetForm();
                };

                var getDayAfterDisplayOn = function(displayOn) {
                    var expMin = new Date(displayOn);
                    expMin.setDate(expMin.getDate() + 1);
                    return expMin
                };

                var setSiteListSelectedValues = function(checked) {
                    ctrl.siteList.map(function (site) {
                        site.selected = checked;
                    })
                };

                ctrl.$onInit = function () {
                    initializeAlertFromId(ctrl.alertId);
                    ctrl.isSelectAllChecked = false;
                    ctrl.removeOnMinDate = "";
                };

                ctrl.setRemoveOnMinDate = function (displayOn) {
                    ctrl.alert.removeOn = "";
                    ctrl.removeOnMinDate = getDayAfterDisplayOn(displayOn);
                };

                ctrl.onSiteCheck = function (site) {
                    site.selected = !site.selected;
                };

                ctrl.onSelectAllCheck = function (checked) {
                    setSiteListSelectedValues(checked);
                };

                ctrl.areAnySitesSelected = function () {
                    var isSelected = function (site) {
                        return site.selected;
                    };

                    return _.some(ctrl.siteList, isSelected);
                };

                ctrl.submit = function() {
                    ctrl.alert.sites = angular.copy(ctrl.siteList);
                    alertDataLayer.alertFormSubmit(ctrl.alert)
                    .then(submitCallback);
                };

                ctrl.dateTomorrow = getTomorrowsDate();
            }]);
})();
