(function () {
    "use strict";

    angular.module("AlertSystem")
        .component("pendingAlertList", {
            templateUrl: "/shared/js/angular/alert-system/pending-alerts/pending-alert-list.html",
            controller: "AlertListController",
            bindings: {
                sites: "<"
            }
        })
        .controller("AlertListController", ["alertDataLayer", "messageHandler", "AlertSystemEdit", "OrderManager", "AlertSystemView",
            function AlertListController(alertDataLayer, messageHandler, AlertSystemEdit, OrderManager, AlertSystemView) {
                var ctrl = this;
                ctrl.orderManager = new OrderManager({}, '-alertId');

                alertDataLayer.getPendingAlerts()
                    .then (function (data) {
                        ctrl.pending = data;
                    });

                ctrl.showAlert = function (alertId) {
                    AlertSystemView.show(alertId);
                };

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
