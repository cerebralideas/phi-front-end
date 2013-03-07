// This creates the global object onto which all
// written JS is attached and provides an application
// wide module as well.
var PAS = angular.module('PAS', [], function ($routeProvider) {

    "use strict";

    var location = window.location.pathname;

    if (location.indexOf('activity') !== -1) {

        $routeProvider.when('/', {
            template: document.getElementById('index').innerHTML
        });

        $routeProvider.when('/:subType/:subId', {
            template: document.getElementById('report').innerHTML
        });
    }
});

// This will be the namespace for attaching controllers
// and other template related needs
PAS.ctrlr = {};

// This will be the namespace for binding UI or Ix functions
// to the application interface.
PAS.bind = {};