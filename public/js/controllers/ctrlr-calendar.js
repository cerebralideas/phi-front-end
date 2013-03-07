/**
 * Controllers for the calendar view.
 *
 * User: Justin Lowery
 * Date: 08/01/12
 * Time: 5:02 PM
 */


PAS.ctrlr.calendar = function ctrlrDotCalendar($scope, $http, $q, $filter, $rootScope, $timeout,
                                               dataServices, dateMgmt) {

    "use strict";

    var day = 86400000;

    // Assign input widths to inputs parents
    $scope.eventFormInputWidth = 'span12';
    $scope.eventFormTextareaWidth = 'span12';


    /************************************\
     * This is the list view section
     */


    $scope.apts = DATA.aptList;
    $scope.adms = DATA.admList;


    /************************************\
     * Initialize start and end dates
     */

    $scope.currentStartDate = $scope.startDate = DATA.startDate;
    $scope.currentEndDate = $scope.endDate = DATA.endDate;
    $scope.startDateMil = Date.parse(DATA.startDate);
    $scope.endDateMil = Date.parse(DATA.endDate);

    $scope.curViewedDay = $scope.startDate;


    /************************************\
     * This is the admission section
     *
     * TODO: I'd like for the startDate to auto-populate to the
     * currently viewed date.
     */


    if (DATA.adm) {

        $scope.adm = function () {

            $scope.fullName = DATA.ptName.firstName + ' ' + DATA.ptName.lastName;

            $scope.ptInfo = DATA.adm.ptInfo;
            $scope.status = DATA.adm.status;
            $scope.notes = DATA.adm.notes;
            $scope.admDetails = DATA.adm.admDetails;
            $scope.md = DATA.adm.md;
            $scope.location = DATA.adm.location;
        };

        $scope.newAdm = function () {

            $scope.fullName = "Click here to search for a patient.";

            $scope.ptInfo = DATA.newAdm.ptInfo;
            $scope.status = DATA.newAdm.status;
            $scope.notes = DATA.newAdm.notes;
            $scope.admDetails = DATA.newAdm.admDetails;
            $scope.md = DATA.newAdm.md;
            $scope.location = DATA.newAdm.location;

            DATA.adm = DATA.newAdm;
        };
    }


    /************************************\
     * This is the appointment section
     *
     * TODO: I'd like for the startDate to auto-populate to the
     * currently viewed date.
     */


    if (DATA.apt) {

        $scope.apt = function () {

            $scope.fullName = DATA.ptName.firstName + ' ' + DATA.ptName.lastName;

            $scope.ptInfo = DATA.apt.ptInfo;
            $scope.md = DATA.apt.md;
            $scope.aptDetails = DATA.apt.aptDetails;
            $scope.status = DATA.apt.status;
            $scope.notes = DATA.apt.notes;
        };

        $scope.newApt = function () {

            $scope.ptSelected = 'ng-invalid-required';

            $scope.fullName = "Click here to search for a patient.";

            $scope.ptInfo = DATA.newApt.ptInfo;
            $scope.md = DATA.newApt.md;
            $scope.aptDetails = DATA.newApt.aptDetails;
            $scope.status = DATA.newApt.status;
            $scope.notes = DATA.newApt.notes;

            DATA.apt = DATA.newApt;
        };
    }


    /************************************\
     * This is the selecting an event function
     */

    $scope.$on('useTimeSlot', function (localScope, date, time, md) {

        $scope.aptDetails.startDate = date;
        $scope.aptDetails.startTime = time;
        $scope.md.clinic = md;

    });


    /************************************\
     * This is the search event function
     */


    $scope.$on('getSearchQuery', function (source, aptUrl, admUrl, startDate, endDate) {

        // construct url
        aptUrl = '/aptasync/getaptsbydate?startDate=' + startDate +
                '&endDate=' + endDate;
        admUrl = '/admasync/getadmsbydate?startDate=' + startDate +
                '&endDate=' + endDate;

        $scope.startDate = startDate;
        $scope.endDate = endDate;

        dateMgmt.move(aptUrl).then(function (returned) {

            $scope.apts = returned.data;
        });

        dateMgmt.move(admUrl).then(function (returned) {

            $scope.adms = returned.data;
        });
    });


    /************************************\
     * This is the forward and back functionality
     * for the day view.
     */


    $scope.oneUp = function oneUp(unit) {

        var aptUrl,
            admUrl;

        if (unit === 'day') {

            // Add day to current date
            $scope.startDateMil = $scope.startDateMil + day;
            $scope.endDateMil = $scope.endDateMil + day;
        }

        $scope.startDate = $filter('date')($scope.startDateMil, 'MM/dd/yyyy');
        $scope.endDate = $filter('date')($scope.endDateMil, 'MM/dd/yyyy');
        $scope.currentEndDate = $scope.currentStartDate = $scope.startDate;

        // construct url
        aptUrl = '/aptasync/getaptsbydate?startDate=' + $scope.startDate +
                '&endDate=' + $scope.endDate;
        admUrl = '/admasync/getadmsbydate?startDate=' + $scope.startDate +
                '&endDate=' + $scope.endDate;

        dateMgmt.move(aptUrl).then(function (returned) {

            $scope.apts = returned.data;
        });

        dateMgmt.move(admUrl).then(function (returned) {

            $scope.adms = returned.data;
        });
    };

    $scope.oneDown = function oneDown(unit) {

        var aptUrl,
            admUrl;

        if (unit === 'day') {

            // Add day to current date
            $scope.startDateMil = $scope.startDateMil - day;
            $scope.endDateMil = $scope.endDateMil - day;
        }

        $scope.startDate = $filter('date')($scope.startDateMil, 'MM/dd/yyyy');
        $scope.endDate = $filter('date')($scope.endDateMil, 'MM/dd/yyyy');
        $scope.currentEndDate = $scope.currentStartDate = $scope.startDate;

        // construct url
        aptUrl = '/aptasync/getaptsbydate?startDate=' + $scope.startDate +
                '&endDate=' + $scope.endDate;
        admUrl = '/admasync/getadmsbydate?startDate=' + $scope.startDate +
                '&endDate=' + $scope.endDate;

        dateMgmt.move(aptUrl).then(function (returned) {

            $scope.apts = returned.data;
        });

        dateMgmt.move(admUrl).then(function (returned) {

            $scope.adms = returned.data;
        });
    };


    /************************************\
     * This is the user selection section
     */


    $scope.selectPatient = function () {

        var $ = jQuery;

        $scope.ptSelected = '';

        $scope.ptInfo.uniqueId = this.pt.uniqueId;

        $scope.fullName = this.pt.firstName + ' ' + this.pt.lastName;

        $('#ptSearchModal').modal('hide');
    };


    /************************************\
     * This is the save patient function
     */


    $scope.save = function (type, form) {

        var newEventDate = (type === 'apt') ? $scope.aptDetails.startDate : $scope.admDetails.date;

        if ($rootScope.invalidDate) {

            return;
        }

        $rootScope.isSaving = 'true';

        form = $scope[form];

        if (!(form.$invalid)) {

            dataServices.fn.save(type).then(function (returned) {

                console.log('Submission success returned.');

                $rootScope.isSaving = 'false';
                $rootScope.isSaved = 'true';

                $timeout(function () { $rootScope.clearSaved(); }, 1500);

                console.log('Returning id - ' + parseInt(returned.data, 10) + ' - for newly created event.');

                $scope[type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);

            }).then(function () {

                var url = '/' + type.toLowerCase() + 'async/get' + type.toLowerCase() + 'sbydate?startDate=' +
                        newEventDate + '&endDate=' + newEventDate;

                dataServices.fn.query(url).then(function (returned) {

                    $scope[type + 's'] = returned.data;

                    $scope.startDate = newEventDate;
                    $scope.endDate = newEventDate;

                    $scope.startDateMil = Date.parse(newEventDate);
                    $scope.endDateMil = Date.parse(newEventDate);

                    $scope.curViewedDay = $scope.startDate;
                });
            });
        }
    };
};

