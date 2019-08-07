(function() {
    "use strict";
    
    angular.module('AlertSystem')
    
        .factory('_', ['$window', function ($window) {
            // some pages use lodash instead of underscore, use:
            // window.underscore = _.noConflict()
            // to ensure compatibility with angular services
            return $window.underscore || $window._;
        }]);
    })();