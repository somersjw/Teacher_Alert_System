(function() {
    'use strict';

    angular.module('AlertSystem')
        .factory('AlertSystemEventBroker', ['alertSystemSubmissionHandler', function (alertSystemSubmissionHandler) {

            function AlertSystemEventBroker (actionString) {

                var self = this;
                self.actionString = actionString;
                function subscribe(callback) {
                    self.callback = callback;
                    alertSystemSubmissionHandler.subscribe(formSubmitEventBrokerCallback);
                }

                function unsubscribe() {
                    alertSystemSubmissionHandler.unsubscribe(formSubmitEventBrokerCallback);
                }

                function formSubmitEventBrokerCallback(action, value) {
                    if (shouldUpdate(action)) {
                        self.callback(value);
                    }
                }

                function shouldUpdate(action) {
                    return action === self.actionString;
                }

                return {
                    subscribe : subscribe,
                    unsubscribe : unsubscribe
                }


            }

            return AlertSystemEventBroker;

        }])
})();