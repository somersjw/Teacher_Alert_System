(function () {
    "use strict";

    angular.module("AlertSystem")
        .component("notificationList", {
            templateUrl: "./content/js/angular/notification-list.html",
            controller: "NotificationListController"
        })
        .controller("NotificationListController", ["notificationDataService", "ModalService",
            function NotificationListController(notificationDataService, ModalService) {
                var ctrl = this;
                ctrl.notificationInfo = [];

                // notificationDataService.getUserNotifications()
                //     .then (function (data) {
                //         ctrl.notificationInfo = data;
                //     });

                ctrl.getColor = function () {
                    return (parseInt(ctrl.notificationInfo.unseenCount) > 0) ? {color: "red"} : {color: "black"};
                };

                ctrl.showNotifications = function () {
                    ModalService.showModal({
                        controller: "NotificationModal",
                        controllerAs: "$ctrl",
                        templateUrl: '/shared/js/angular/notifications/user-notifications.html',
                        inputs: {notificationInfo: ctrl.notificationInfo}
                    });
                };

            }
        ]).controller("NotificationModal", ["notificationInfo", "close", "notificationDataService",
            function (notificationInfo, close, notificationDataService) {
                var ctrl = this;
                ctrl.selected = 0;
                ctrl.notificationInfo = notificationInfo;

                ctrl.close = function () {
                    close();
                };

                ctrl.readAlert = function (alert) {
                    updateSelected(alert.alertId);
                    if (!alert.viewedAt) {
                        ctrl.markAsRead(alert);
                    }
                };

                ctrl.markAsRead = function (alert) {
                    alert.viewedAt = getCurrentDatetime();
                    var data = {'alertId' : alert.alertId, 'viewedAt' : alert.viewedAt };
                    notificationDataService.markAsRead(data)
                        .then(function () {
                            ctrl.notificationInfo.unseenCount -= 1;
                        });
                };

                var getCurrentDatetime = function () {
                    return new Date().toISOString().slice(0, 19).replace('T', ' ');
                };

                var updateSelected = function (alertId) {
                    ctrl.selected = (ctrl.selected === alertId) ? 0 : alertId;
                };
            }
    ]);
})();
