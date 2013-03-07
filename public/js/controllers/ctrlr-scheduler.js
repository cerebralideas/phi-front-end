/**
 * Controller for the scheduler include.
 *
 * User: Justin Lowery
 * Date: 10/16/12
 * Time: 10:02 PM
 */


PAS.ctrlr.scheduler = function ctrlrDotScheduler($scope, dataServices, $filter) {

    "use strict";

    var day = 86400000,
        todayObj = new Date(),
        startDateMil,
        endDateMil,
        getApts,
        today = $filter('date')(todayObj, 'MM/dd/yyyy');

    getApts = function getApts(url) {

        dataServices.fn.query(url).then(function (returned) {

            $scope.clinicHours = returned.data;
        });
    };

    $scope.startDate = today;
    $scope.endDate = today;
    startDateMil = Date.parse($scope.startDate);
    endDateMil = Date.parse($scope.endDate);
    $scope.curViewedDay = $filter('date')(todayObj, 'EEE MM/dd/yyyy');
    $scope.counter = 0;

    $scope.selectTime = function (md) {

        $scope.desiredTime = md.time;
        $scope.desiredMd = md.md;
    };

    $scope.isBlocked = function isBlocked(bool) {

        return bool ? 'blocked' : '';
    };

    $scope.isAvailable = function isAvailable(blocked, apt) {

        if (blocked === 'false' && apt === null) {

            return 'true';

        } else if (apt) {

            return '';

        } else {

            return 'false';
        }
    };

    $scope.$on('selectClinic', function (localScope, clinic) {

        var url;

        console.log($scope.selectedClinic);

        if (clinic) {

            $scope.selectedClinic = clinic.replace(/\s/g, '+');

            url = '/aptasync/getavailabilitybydate?location=' + $scope.selectedClinic + '&date=' + $scope.startDate;

            console.log(url);

            getApts(url);
        }
    });

    $scope.oneUp = function oneUp(unit) {

        var url;

        if (unit === 'day') {

            // Add day to current date
            startDateMil = startDateMil + day;
            endDateMil = endDateMil + day;
        }

        $scope.startDate = $filter('date')(startDateMil, 'MM/dd/yyyy');
        $scope.endDate = $filter('date')(endDateMil, 'MM/dd/yyyy');
        $scope.curViewedDay = $filter('date')(startDateMil, 'EEE MM/dd/yyyy');

        // construct url
        url = '/aptasync/getavailabilitybydate?location=' + $scope.selectedClinic + '&date=' + $scope.startDate;

        getApts(url);
    };

    $scope.oneDown = function oneDown(unit) {

        var url;

        if (unit === 'day') {

            // Add day to current date
            startDateMil = startDateMil - day;
            endDateMil = endDateMil - day;
        }

        $scope.startDate = $filter('date')(startDateMil, 'MM/dd/yyyy');
        $scope.endDate = $filter('date')(endDateMil, 'MM/dd/yyyy');
        $scope.curViewedDay = $filter('date')(startDateMil, 'EEE MM/dd/yyyy');

        // construct url
        url = '/aptasync/getavailabilitybydate?location=' + $scope.selectedClinic + '&date=' + $scope.startDate;

        getApts(url);
    };
};