angular.module('AlertSystem')

    .factory('alertSystemSubmissionHandler', ['_', function (_) {
        var subscribers = [];
        var service = {
            publishSubmission: publishSubmission,
            subscribe: subscribe,
            unsubscribe: unsubscribe
        };
        return service;

        function publishSubmission(action, value) {
            _.each(subscribers, function notifyListener(listener) {
                listener(action, value);
            });
        }

        function subscribe(listener) {
            subscribers.push(listener);
        }

        function unsubscribe(listener) {
            subscribers = _.filter(subscribers, function (subscriber) {
                return subscriber !== listener;
            })
        }
    }]);