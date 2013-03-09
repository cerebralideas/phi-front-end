PHI.directive('timeInput', function () {

	"use strict";

	return {

		restrict: 'E',
		replace: true,
		template:   '<div class="input"><!--<div class="input-prepend">-->' +
					'<!--<div class="icon-calendar add-on"></div>-->' +
					'<input name="{{name}}" ' +
					'ng-disabled="disable" type="text" class="timeInputType" id="{{id}}" ' +
					'ng-model="model" ng-pattern="timeVal" ng-maxlength="4" required="{{required}}">' +
					'</div>',
		scope: {

			'required': '@',
			'name': '@',
			'id': '@',
			'model': '=',
			'disable': '='
		},
		link: function (scope, element, attr) {

			scope.timeVal = /^[0-9]{4}$/;

			scope.$watch(element);

			angular.element(element).find('input')[0].onkeydown = function (e) {

				var value = this.value;

				console.log(e.keyCode);

				if (e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 9 && e.keyCode !== 91) {

					if (e.keyCode < 37) {

						e.preventDefault();

					} else if (e.keyCode > 40 && e.keyCode < 48) {

						e.preventDefault();

					} else if (e.keyCode > 57 && e.keyCode < 96) {

						e.preventDefault();

					} else if (e.keyCode > 105) {

						e.preventDefault();
					}
				}
			};

			angular.element(element).find('input')[0].onfocus = function () {

				var el = angular.element(element).find('input')[0];

				angular.element(el).attr('placeholder', 'e.g. 0800');
			};

			angular.element(element).find('input')[0].onblur = function () {

				var el = angular.element(element).find('input')[0];

				angular.element(el).removeAttr('placeholder');
			};
		}
	};
});