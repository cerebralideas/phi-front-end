// Click Event Delegation
// This has been adapted from https://github.com/nishp1/angular-delegate-event
PHI.directive('dgClick', function ($parse) {

	"use strict";

	return function(scope, element, attr) {

		var fn = $parse(attr.dgClick);

		element.bind('click'.toLowerCase(), function(evt) {

			scope.$apply(function() {

				fn(angular.element(evt.target).scope(), {$event:evt});
			});
		});
	};
});