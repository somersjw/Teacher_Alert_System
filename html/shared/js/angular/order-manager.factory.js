(function() {
"use strict";

angular.module('shared')

    .factory('OrderManager', ['$window', function( $window) {
        return function OrderManager(predicateMap, initialOrder, initialReverse) {
            var field;
            var reverse = false;
            var predicate = undefined;
            var predicates = predicateMap;
            var sessionKey;

            orderBy(initialOrder, initialReverse);

            function orderBy(newField, newReverse) {
                if (newReverse !== undefined) {
                    reverse = !!newReverse;
                } else if (newField != field) {
                    reverse = false;
                } else {
                    reverse = !reverse;
                }
                field = newField;
                if (newField in predicates) {
                    predicate = predicates[newField];
                } else {
                    predicate = newField;
                }
                saveToSession(field, reverse);
            }

            function isOrderBy(testField) { return field == testField; }
            function getField() { return field; }
            function getPredicate() { return predicate; }
            function getReverse() { return reverse; }
            function getComparator() { return undefined; }
            function setSessionKey(key) {
                console.assert(_.isString(key));
                sessionKey = key;
                initFromSession()
            }
            function initFromSession() {
                if (_.isString(sessionKey)) {
                    var sessionValue = $window.sessionStorage.getItem(sessionKey);
                    try {
                        var value = JSON.parse(sessionValue);
                        if (value.hasOwnProperty('field') && value.hasOwnProperty('reverse')) {
                            orderBy(value.field, value.reverse);
                        }
                    } catch (error) {}
                }
            }
            function saveToSession(field, reverse) {
                if (_.isString(sessionKey)) {
                    $window.sessionStorage.setItem(sessionKey, JSON.stringify({field: field, reverse: reverse}));
                }
            }

            return {
                orderBy: orderBy,
                getField: getField,
                getPredicate: getPredicate,
                getReverse: getReverse,
                getComparator: getComparator,
                isOrderBy: isOrderBy,
                setSessionKey: setSessionKey
            };
        }
    }])
})();