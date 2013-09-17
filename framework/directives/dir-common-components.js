angular.module('phi-common-components', []).
		directive('warningMessages', function ($timeout) {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:
						'<div class="center alert" ' +
							 'data-ng-show="(form.$error.required || form.$error.pattern) && form.$dirty">' +
								'<p class="tenColumns">This form has ' +
									'<span data-ng-bind="form.$error.required.length + form.$error.pattern.length">' +
										'?' +
									'</span> warning(s). ' +
									'<a href="#" data-ng-click="showErrors()">' +
										'{{linkMessage}}' +
									'</a>' +
								'</p> ' +
								'<div class="eightColumns" data-ng-show="displayErrors">' +
									'<p>The following fields have errors: ' +
										'<span data-ng-repeat="error in form.$error.required" class="formError">' +
											'{{error.$name}}, ' +
										'</span>' +
									'</p>' +
								'</div>' +
							'</div>',
				scope: false,
				link: function (scope, element, attr) {

					var form = attr.form;

					scope.form = scope[form];
					scope.displayErrors = false;
					scope.linkMessage = "Click here for more info.";

					scope.showErrors = function showErrors() {

						if (scope.displayErrors === false) {

							scope.displayErrors = true;
							scope.linkMessage = "Click here to hide info.";

						} else {

							scope.displayErrors = false;
							scope.linkMessage = "Click here for more info.";
						}
					};
				}
			};
		}).
		directive('modal', function() {

			'use strict';

			return {
				replace: false,
				restrict: 'E',
				transclude: true,
				scope: true,
				template: '<div ng-transclude></div>',
				compile: function(tElement, tAttrs, transclude) {

					return {
						pre: function(scope, elem, attr) {
							document.body.appendChild(elem[0]);
						},
						post: function(scope, elem, attr) {

						}
					};
				}
			};
		});