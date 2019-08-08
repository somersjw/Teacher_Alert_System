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

            function getAlert(alertId) {
                return $http.get("/api/alert-system/alert/" + alertId);
            }

            function editAlert(formAlert) {
                return $http.patch("/api/alert-system/alert", formAlert);
            }

            function deleteAlert(alertId) {
                return $http.delete("/api/alert-system/alert/" + alertId);
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