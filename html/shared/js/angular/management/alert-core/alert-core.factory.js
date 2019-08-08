(function () {
    "use strict";

    angular.module("AlertSystem")
        .factory("alertDataService", ["$q", "$http", function ($q, $http) {

            function getSiteList() {
                return $http.get("/api/alert-system/sites");
            }

            function createAlert(alert) {
                return $http.post("/api/alert-system/alert", alert);
            }

            function getPendingAlerts() {
                return $http.get("/api/alert-system/pending");
            }

            // Have to use post in hacky way, LAZ routing allowed for slugs while this open source does not
            // TODO: find a router that supports slugs
            function getAlert(alertId) {
                var data = {"alertId" : alertId};
                return $http.post("/api/alert-system/getalert", data);
            }

            function editAlert(formAlert) {
                return $http.post("/api/alert-system/editalert", formAlert);
            }

            function deleteAlert(alertId) {
                var data = {"alertId" : alertId};
                return $http.post("/api/alert-system/alertbyid", data);
            }

            return {
                getSiteList: getSiteList,
                createAlert: createAlert,
                getPendingAlerts: getPendingAlerts,
                getAlert: getAlert,
                editAlert: editAlert,
                deleteAlert: deleteAlert
            };
        }]);
})();