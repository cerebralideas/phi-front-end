/**
 * This are all the controllers for the patient view.
 * User: Justin Lowery
 * Date: 7/28/12
 * Time: 6:24 PM
 */

PAS.ctrlr.activity = function ctrlrDotActivity($scope, $http, $q, $location, $routeParams, $route, dataServices,
                                               objectServices) {

    "use strict";


    /************************************\
     * Variable and function initialization/assignment
     */


    var url;

    function checkForValues(inputToCheck, selectedValue) {

        var value;

        if (inputToCheck || selectedValue === "Yes") {

            value = 'true';

        } else {

            value = 'false';
        }

        return value;
    }

    // Assign input widths to inputs parents
    $scope.eventFormInputWidth = 'span4';
    $scope.eventFormTextareaWidth = 'span8';

    $scope.onReport = true;

    // function for retrieving data and assigning it to $scoped elements
    function getAndAssignData(url, subId) {

        dataServices.fn.query(url).then(function (returned) {

            console.log(returned.data);

            DATA.item.reg = returned.data;

            if (returned.data.item.pt) {

                $scope.pt = returned.data.item.pt;
                $scope.pg = returned.data.item.pg;
                $scope.md = returned.data.item.md;
                $scope.gr = returned.data.item.gr;
                $scope.ins = returned.data.item.ins;

                $scope.hasPrimary = checkForValues($scope.ins.primary.relationship, $scope.hasPrimary);
                $scope.hasSecondary = checkForValues($scope.ins.secondary.relationship, $scope.hasSecondary);
                $scope.hasTertiary = checkForValues($scope.ins.tertiary.relationship, $scope.hasTertiary);

            } else if (returned.data.item.aptDetails) {

                $scope.ptInfo = returned.data.item.ptInfo;
                $scope.aptDetails = returned.data.item.aptDetails;
                $scope.md = returned.data.item.md;
                $scope.status = returned.data.item.status;
                $scope.notes = returned.data.item.notes;

            } else if (returned.data.item.opSbDetails) {

                $scope.pt = returned.data.reg.pt;
                $scope.ins = returned.data.reg.ins;
                $scope.ptInfo = returned.data.apt.ptInfo;
                $scope.aptDetails = returned.data.apt.aptDetails;
                $scope.md = returned.data.apt.md;
                $scope.status = returned.data.apt.status;
                $scope.notes = returned.data.apt.notes;
                $scope.opSb = returned.data.item;

            } else if (returned.data.item.opClDetails) {

                $scope.pt = returned.data.reg.pt;
                $scope.ins = returned.data.reg.ins;
                $scope.ptInfo = returned.data.apt.ptInfo;
                $scope.aptDetails = returned.data.apt.aptDetails;
                $scope.md = returned.data.apt.md;
                $scope.status = returned.data.apt.status;
                $scope.notes = returned.data.apt.notes;
                $scope.opSb = returned.data.opSb;
                $scope.opCl = returned.data.item;

            } else if (returned.data.item.admDetails) {

                $scope.ptInfo = returned.data.item.ptInfo;
                $scope.admDetails = returned.data.item.admDetails;
                $scope.md = returned.data.item.md;
                $scope.status = returned.data.item.status;
                $scope.clinic = returned.data.item.location;
                $scope.notes = returned.data.item.notes;
            }

            $scope.ptFullName = returned.data.meta.pt;
            $scope.subFaculty = returned.data.meta.faculty;
            $scope.subStudent = returned.data.meta.student;
            $scope.subDate = returned.data.meta.subDate;

        }).then(function () {

            var url = '/activityasync/getcomments?subId=' + subId;

            dataServices.fn.query(url).then(function (returned) {

                $scope.comments = returned.data;
            });
        });
    }

    function saveComment(comment) {

        var url = '/activityasync/insertsubmissioncomment?subId=' + $routeParams.subId + '&comment=' + comment;

        return $http.post(url).
            success(function (data, status) {

                console.log('Status code ' + status + ': posting of comment was successful :)');

            }).error(function (data, status) {

                console.log('Status code ' + status + ': posting of comment was unsuccessful :(');
            });
    }


    /************************************\
     * View modifications and item assignments
     */


    // Disable all inputs; make read-only for reporting
    $scope.disable = true;

    // assign items to the list
    $scope.items = DATA.itemList;

    // Watch items for changes and if changed, updated view
    $scope.$watch('items');


    /************************************\
     * Routing and State Functionality
     */


    // Watch for route parameter changes, grab data for item and assign to scope
    $scope.$on('$routeChangeSuccess', function () {

        if ($routeParams.subId) {

            url = '/activityasync/getsubmission?subId=' + $routeParams.subId + '&subtype=' + $routeParams.subType;

            getAndAssignData(url, $routeParams.subId);
        }
    });

    // Function used for pseudo-anchor-links to change view without refresh
    $scope.changeRoute = function changeRoute(subId, subType, e) {

        var element = angular.element(e.srcElement),
            elementScope = element.scope(),
            routeSubId,
            iter = 0,
            item;

        console.log(subId + ' ' + subType);

        jQuery('#itemTab').tab('show');

        url = '/activityasync/getsubmission?subId=' + subId + '&subtype=' + subType;

        // Check to see if a subId was passed in, if it was convert to integer
        subId = subId ? parseInt(subId, 10) : null;

        // Check for route parameters for a subId, if exists convert to integer
        routeSubId = $routeParams.subId ? parseInt($routeParams.subId, 10) : null;

        // Check if the user selected an item that is already displayed
        if (subId && subId !== routeSubId) {

            // If new item, reroute to the new item
            $location.path(subType + '/' + subId);
        }
    };


    /************************************\
     * List items assignments, organization and status
     * change functions
     */


    $scope.unreviewed = function (item) {

        return item.subStatus === 'unreviewed';
    };

    $scope.reviewed = function (item) {

        return item.subStatus === 'reviewed';
    };

    $scope.archived = function (item) {

        return item.subStatus === 'archived';
    };

    $scope.reviewItem = function review(comment) {

        jQuery('#statComTab').tab('show');

        if (comment) {
            saveComment(comment).then(function (returned) {

                console.log('Review is complete.');
            });
        }

        if ($scope.admin || $scope.faculty) {

            // TODO: revisit this for performance analysis
            // param: action, property, value, items
            objectServices.fn.modify({
                action: 'review',
                property: 'subStatus',
                value: 'reviewed',
                items: $scope.items,
                item: parseInt($routeParams.subId, 10)
            });
        }

        // Empty out comment textarea
        $scope.subComment = '';

        // TODO: This is an ugly hack to fix the racing issue between
        // the posting to the db above and the query
        setTimeout(function () {
            var url = '/activityasync/getcomments?subId=' + $routeParams.subId;

            dataServices.fn.query(url).then(function (returned) {

                console.log('grab comments');

                $scope.comments = returned.data;
            });
        }, 250);
    };


    /************************************\
     * This is the select-all and archive section
     */


    $scope.archive = function archive() {

        // param: action, property, value, items
        objectServices.fn.bulkModify({
            action: 'archive',
            property: 'subStatus',
            value: 'archived',
            items: $scope.items
        });
    };

    $scope.unarchive = function unarchive() {

        // param: action, property, value, items
        objectServices.fn.bulkModify({
            action: 'unarchive',
            property: 'subStatus',
            value: 'reviewed',
            items: $scope.items
        });
    };

    $scope.selectAll = function selectAll(model, subArray) {

        // param: action, property, value, items
        objectServices.fn.bulkModify({
            action: 'selectAll', // What are you intending to do?
            property: subArray, // What property identifies the items?
            value: $scope[model], // What is the value or state to set?
            items: $scope.items // the actual array of items
        });
    };
};