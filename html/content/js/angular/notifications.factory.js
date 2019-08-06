(function () {
    "use strict";

    angular.module("AlertSystem")
        .factory("notificationDataService", ["$http", function ($http) {
            function getUserNotifications() {
                return $http.get("/api/notifications/messages")
                    .then(function (response) {
                        return response.data;
                    });
            }

            function markAsRead(data) {
                return $http.post("/api/notifications/viewed", data);
            }
            return {
                getUserNotifications: getUserNotifications,
                markAsRead: markAsRead
            };
        }]);
})();