(function () {
    "use strict";

    angular.module("AlertSystem")
        .component("pendingAlertList", {
            templateUrl: "shared/js/angular/management/pending-alerts/pending-alert-list.html",
            controller: "AlertListController",
            bindings: {
                sites: "<"
            }
        })
        .controller("AlertListController", ["alertDataLayer", "messageHandler", "AlertSystemEdit", "OrderManager",
            function AlertListController(alertDataLayer, messageHandler, AlertSystemEdit, OrderManager) {
                var ctrl = this;
                ctrl.orderManager = new OrderManager({}, '-alertId');

                alertDataLayer.getPendingAlerts()
                    .then (function (data) {
                        ctrl.pending = data;
                    });

                ctrl.deleteAlert = function (alertId) {
                    alertDataLayer.deleteAlert(alertId)
                        .then(function() {
                            messageHandler.publishSuccess("Successfully Deleted Alert");
                        });
                };

                ctrl.editAlert = function (alertId) {
                    AlertSystemEdit.show(alertId);
                };
            }
        ]);
})();
