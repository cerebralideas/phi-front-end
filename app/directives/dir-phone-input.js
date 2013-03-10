PHI.directive('phoneNumber', function () {

	"use strict";

	return {

		restrict: 'E',
		replace: true,
		template:   '<input type="text" class="phoneInputType" ' +
					'ng-model="model" ng-pattern="phoneVal" ng-maxlength="12">',
		scope: {

			'model': '='
		},
		link: function (scope, element, attr) {

			scope.phoneVal = /^[0-9]{3}[\-]{0,1}[0-9]{3}[\-]{0,1}([0-9]{4})$/;

			scope.$watch(element);

			element[0].onkeydown = function (e) {

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

			element[0].onfocus = function () {

				angular.element(this).attr('placeholder', '555-555-5555');
			};

			element[0].onblur = function () {

				angular.element(this).removeAttr('placeholder');
			};

			element[0].onkeyup = function (e) {

				var value = this.value,
						length = value.length;

				if (e.keyCode !== 8 && e.keyCode !== 46) {

					if (length === 3 || length === 7) {

						this.value = value + '-';
					}
				}
			};
		}
	}
});