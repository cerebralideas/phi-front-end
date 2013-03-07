PAS.directive('scheduler', function ($rootScope, dataServices, $filter, dateMgmt) {

    "use strict";

    return {

        restrict: 'E',
        replace: true,
        template:   '<div id="scheduler" class="modal hide fade">' +

                        '<div class="scheduler-header">' +

                            '<a data-dismiss="modal" class="close">&#x2612;</a>' +
                            '<h1>' +
                                '<a class="icon" ng-click=\'oneDown("day")\'>&#x2b05;</a>' +
                                    '{{curViewedDay}}' +
                                '<a class="icon" ng-click=\'oneUp("day")\'>&#x27a1;</a>' +
                            '</h1>' +
                        '</div>' +

                        '<div class="modal-body">' +
                            '<p class="formInstructions">' +
                                    'Select a time slot below and click save. Note: you can always ' +
                                    'change this later.</p>' +
                            '<table>' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th>Time</th>' +
                                        '<th ng-repeat="staff in timeSlots[0].mds">{{staff.md}}</th>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                    '<tr ng-repeat="slot in timeSlots">' +

                                        '<td>{{slot.time}}</td>' +
                                        '<td ng-repeat="md in slot.mds"' +
                                                'class="ng-class:isAvailable(md.blocked,md.apt); available"' +
                                                'ng-click="selectTime(slot.time)">' +

                                            '<span class="showThis" ' +
                                                    'ng-show="isAvailable(md.blocked, md.apt)">' +

                                                'Select This Slot' +
                                            '</span>' +

                                            '{{md.apt.patient}}' +
                                        '</td>' +
                                    '</tr>' +
                                '</tbody>' +
                            '</table>' +
                        '</div>' +
                        '<div class="modal-footer">' +

                            '<div class="scheduler-output">' +
                                '<h3>Time: {{desiredTime}} | Date: {{startDate}}.</h3>' +
                            '</div>' +

                            '<a class="btn btn-cancel" data-dismiss="modal" href="">Cancel</a>' +
                            '<a class="btn btn-success" data-dismiss="modal" ' +
                                'ng-click="$emit(\'useDateTime\', startDate, desiredTime)">Save</a>' +
                        '</div>' +

                    '</div>',
        scope: {},
        link: function (scope, element, attr) {

            var day = 86400000,
                today = new Date(),
                getApts,
                timeSlotsArray;

            today = $filter('date')(today, 'MM/dd/yyyy');

            scope.startDate = today;
            scope.endDate = today;
            scope.startDateMil = Date.parse(scope.startDate);
            scope.endDateMil = Date.parse(scope.endDate);
            scope.timeSlots = timeSlotsArray;
            scope.desiredTime = "Not Chosen";
            scope.curViewedDay = scope.startDate;
            scope.counter = 0;

            scope.selectTime = function (value) {

                scope.desiredTime = value;
            };

            scope.isBlocked = function isBlocked(bool) {

                return bool ? 'blocked' : '';
            };

            scope.isAvailable = function isAvailable(blocked, apt) {

                if (blocked === 'false' && apt === null) {

                    return 'true';

                } else if (apt) {

                    return '';

                } else {

                    return 'false';
                }
            };

            scope.$watch('counter', function (newValue, oldValue) {

                console.log('change');

                scope.timeSlots = timeSlotsArray;
            });

            getApts = function getApts(url) {

                dataServices.fn.query(url).then(function (returned) {

                    timeSlotsArray = returned.data;

                    scope.counter = scope.counter + 1;

                    console.log(scope.counter);
                });
            };

            getApts('/aptasync/getavailabilitybydate?location=General+Medical+Clinic&date=' + scope.startDate);

            scope.oneUp = function oneUp(unit) {

                var url;

                if (unit === 'day') {

                    // Add day to current date
                    scope.startDateMil = scope.startDateMil + day;
                    scope.endDateMil = scope.endDateMil + day;
                }

                scope.startDate = $filter('date')(scope.startDateMil, 'MM/dd/yyyy');
                scope.endDate = $filter('date')(scope.endDateMil, 'MM/dd/yyyy');
                scope.curViewedDay = scope.startDate;

                // construct url
                url = '/aptasync/getavailabilitybydate?location=General+Medical+Clinic&date=' + scope.startDate;

                getApts(url);
            };

            scope.oneDown = function oneDown(unit) {

                var url;

                if (unit === 'day') {

                    // Add day to current date
                    scope.startDateMil = scope.startDateMil - day;
                    scope.endDateMil = scope.endDateMil - day;
                }

                scope.startDate = $filter('date')(scope.startDateMil, 'MM/dd/yyyy');
                scope.endDate = $filter('date')(scope.endDateMil, 'MM/dd/yyyy');
                scope.curViewedDay = scope.startDate;

                // construct url
                url = '/aptasync/getavailabilitybydate?location=General+Medical+Clinic&date=' + scope.startDate;

                getApts(url);
            };
        }
    };
});