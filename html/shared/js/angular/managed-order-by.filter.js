(function() {
"use strict";

angular.module('AlertSystem')

    .filter('managedOrderBy', ['orderByFilter', function (orderByFilter) {
        return function (collection, orderByManager) {
            return orderByFilter(collection, orderByManager.getPredicate(), orderByManager.getReverse(), orderByManager.getComparator());
        }
    }])
})();