(function () {
    "use strict";

    angular.module("AlertSystem")
        .factory("alertDataLayer", ["$q", "$http", "alertDataService", "messageHandler",
            function ($q, $http, alertDataService, messageHandler) {
                var ctrl = this;
                ctrl.siteList = [];
                ctrl.pendingAlerts = [];

                function handleError(reason) {
                    console.debug(reason);
                    messageHandler.error(reason);
                    throw new Error(reason);
                }
                function catchError(response) {
                    handleError(response.data.message);
                }

                function isAlertIdValid(alertId) {
                    return !isNaN(parseInt(alertId));
                }

                function getSiteList() {
                    if (ctrl.siteList.length) {
                        return $q.resolve(angular.copy(ctrl.siteList));
                    }
                    else {
                        return alertDataService.getSiteList()
                            .then(function (response) {
                                setSiteList(response.data);
                                return angular.copy(ctrl.siteList);
                            })
                            .catch(catchError);
                    }
                }

                function setSiteList(data) {
                    ctrl.siteList = data;
                }

                function getPendingAlerts() {
                    var defer = $q.defer();
                    alertDataService.getPendingAlerts()
                        .then(function(response){
                            setPendingAlerts(response.data);
                            defer.resolve(ctrl.pendingAlerts);
                        })
                        .catch(catchError);
                    return defer.promise;
                }

                function setPendingAlerts(data) {
                    ctrl.pendingAlerts = data;
                }

                function alertFormSubmit(alert) {
                    alert.sites = _.filter(alert.sites, function(site) {
                        return site.selected;
                    });

                    var defer = $q.defer();
                    if ("alertId" in alert) {
                        if (!isAlertIdValid(alert.alertId)) {
                            handleError("Alert ID is invalid.")
                        }

                        alertDataService.editAlert(alert)
                            .then(function (response) {
                                updateRowData(response.data);
                                messageHandler.publishSuccess("Alert has been successfully updated");
                                defer.resolve(true);
                            })
                            .catch(catchError);
                    }
                    else {
                        alertDataService.createAlert(alert)
                            .then(function (response) {
                                addAlertToPendingTable(response.data, alert);
                                messageHandler.publishSuccess("Alert has been successfully created");
                                defer.resolve(true);
                            })
                            .catch(catchError);
                    }
                    return defer.promise;
                }

                function addAlertToPendingTable(data, alert) {
                    ctrl.pendingAlerts.push(formatNewAlertForTable(alert, data));
                }

                function formatNewAlertForTable(alert, alertId) {
                    alert.alertId = alertId.toString();
                    alert.displayOn = alert.displayOn.toISOString().split("T")[0];
                    alert.removeOn = alert.removeOn.toISOString().split("T")[0];
                    var siteCSV = "";

                    alert.sites.map(function (item) {
                        siteCSV = siteCSV.concat(item.name, ", ");
                    });

                    siteCSV = siteCSV.substring(0, siteCSV.length - 2);
                    alert.alertSites = siteCSV;
                    return alert;
                }

                function updateRowData(data) {
                    var alertToEdit = findPendingAlertById(data.alertId);
                    alertToEdit.alertTitle = data.alertTitle;
                    alertToEdit.alertMessage = data.alertMessage;
                    alertToEdit.displayOn = data.displayOn;
                    alertToEdit.removeOn = data.removeOn;
                    alertToEdit.alertSites = data.alertSites;
                }

                function findPendingAlertById(alertId) {
                    if (isAlertIdValid(alert.alertId)) {
                        handleError("Alert ID is invalid.")
                    }

                    alert = _.filter(ctrl.pendingAlerts, function (pendingAlert) {
                        return pendingAlert.alertId === alertId;
                    });
                    return (alert.length) ? alert[0] : null;
                }

                function deleteAlert(alertId) {
                    if (isAlertIdValid(alert.alertId)) {
                        handleError("Alert ID is invalid.")
                    }

                    var defer = $q.defer();
                    alertDataService.deleteAlert(alertId)
                        .then(function () {
                            removeAlertFromPending(alertId);
                            defer.resolve(true);
                        })
                        .catch(catchError);
                    return defer.promise;
                }

                function removeAlertFromPending(alertId) {
                    if (isAlertIdValid(alert.alertId)) {
                        handleError("Alert ID is invalid.")
                    }

                    for (var i = ctrl.pendingAlerts.length - 1; i >= 0; --i) {
                        if (ctrl.pendingAlerts[i].alertId === alertId) {
                            ctrl.pendingAlerts.splice(i,1);
                            return;
                        }
                    }
                }

                function updateSiteListSelectedFromAlert(sites) {
                    var alertSiteList = angular.copy(ctrl.siteList);
                    for (var i = 0; i < sites.length; ++i) {
                        for (var j = 0; j < alertSiteList.length; ++j) {
                            if (parseInt(sites[i].siteId) === alertSiteList[j].siteId) {
                                alertSiteList[j].selected = true;
                            }
                        }
                    }
                    return alertSiteList;
                }

                function getAlert(alertId) {
                    if (isAlertIdValid(alert.alertId)) {
                        handleError("Alert ID is invalid.")
                    }

                    var defer = $q.defer();
                    alertDataService.getAlert(alertId)
                        .then(function (response) {
                            response.data.sites = updateSiteListSelectedFromAlert(response.data.sites);
                            defer.resolve(response);
                        })
                        .catch(catchError);
                    return defer.promise;
                }

                return {
                    getSiteList: getSiteList,
                    getPendingAlerts: getPendingAlerts,
                    alertFormSubmit: alertFormSubmit,
                    deleteAlert: deleteAlert,
                    getAlert: getAlert
                };
        }]);
})();