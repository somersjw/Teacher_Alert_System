(function () {
    "use strict";

angular.module("AlertSystem")
    .factory("AlertSystemEdit", ["ModalService", "messageHandler", function (ModalService, messageHandler) {
        function ShowAlerts() {
            var self = this;

            self.show = function (alertId) {
                ModalService.showModal({
                    controller: "AlertSystemEditModal",
                    controllerAs: "$ctrl",
                    templateUrl: "shared/js/angular/management/pending-alert-edit/edit-form.html",
                    inputs: {
                        alertId: alertId
                    }
                })
                    .catch(function (reason) {
                        console.debug(reason);
                        messageHandler.error("There was a problem processing your request.");
                    });
            };
        }

        return new ShowAlerts();
    }])
    .controller("AlertSystemEditModal", ["alertId", "close", "AlertSystemEventBroker",
        function AlertEditController(alertId, close, AlertSystemEventBroker) {
            var ctrl = this;
            ctrl.alertId = alertId;

            var eventBroker = new AlertSystemEventBroker("submit");

            ctrl.close = function () {
                eventBroker.unsubscribe();
                close();
            };

            var submitCallback = function () {
                ctrl.close();
            };

            eventBroker.subscribe(submitCallback);

            ctrl.$onDestroy = function() {
                eventBroker.unsubscribe();
            };
        }
    ]);
})();