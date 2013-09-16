/************************************\
 * This is the global directives for common form stuff
 */


	// Click Event Delegation
	// This has been adapted from https://github.com/nishp1/angular-delegate-event
	angular.module('phi-common-inputs', []).
		directive('dateInput', function ($rootScope, $filter) {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:   '<input type="text" class="dateInputType" ' +
						'data-ng-model="model" data-ng-pattern="dateVal" data-ng-maxlength="10"' +
						'data-ng-disabled="disable" data-ng-change="checkIfValid()"' +
						'>',
				scope: {

					'model': '=',
					'disable': '='
				},
				link: function (scope, element, attr) {

					scope.dateVal = /^[0-9]{2}[\/]{0,1}[0-9]{2}[\/]{0,1}([0-9]{2}|[0-9]{4})$/;

					scope.$watch(element);

					element[0].onkeydown = function (e) {

						var value = this.value;

						// console.log(e.keyCode);

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

					scope.checkIfValid = function () {

						var that = element[0],
								newEventDateMil,
								parsedEventDate;

						if (that.value.length > 6) {

							newEventDateMil = Date.parse(that.value);
							parsedEventDate = $filter('date')(newEventDateMil, 'MM/dd/yyyy');

							if (that.value !== parsedEventDate) {

								console.error('Your start date is not a valid date');

								$rootScope.invalidDate = true;

							} else {

								$rootScope.invalidDate = false;

								$rootScope.$digest();
							}
						}
					};

					element[0].onfocus = function () {

						var el = element[0];

						angular.element(el).attr('placeholder', 'MM/DD/YYYY');
					};

					element[0].onblur = function () {

						var value = this.value,
								el = element[0],
								dateArray,
								currentYear = new Date().getFullYear(),
								fourDigitYear;

						if (/[0-9]{2,2}[\/]{0,1}[0-9]{2,2}[\/]{0,1}[0-9]{2,2}/.test(value)) {

							dateArray = value.split('/');
							currentYear = currentYear.toString().slice(2,4);
							currentYear = parseInt(currentYear, 10);

							if (dateArray[2] <= (currentYear + 2) && dateArray[2].length === 2) {

								fourDigitYear = '20' + dateArray[2].toString();

								this.value = dateArray[0] + '/' + dateArray[1] + '/' + fourDigitYear;
								scope.model = this.value;

							} else if (dateArray[2] > (currentYear + 1) && dateArray[2].length === 2) {

								fourDigitYear = '19' + dateArray[2].toString();

								this.value = dateArray[0] + '/' + dateArray[1] + '/' + fourDigitYear;
								scope.model = this.value;
							}
						}

						scope.checkIfValid();

						angular.element(el).removeAttr('placeholder');

						if (attr.function) {

							$rootScope.$broadcast(attr.function, true, this.value);
						}
					};

					element[0].onkeyup = function (e) {

						var value = this.value,
								length = value.length,
								subStr;

						if (e.keyCode !== 8 && e.keyCode !== 46) {

							if (length === 2 || length === 5) {

								this.value = value + '/';

							} else if (length === 1) {

								if (e.keyCode === 191 || e.keyCode === 189 || e.keyCode === 109 || e.keyCode === 111) {

									this.value = '0' + value + '/';
								}
							} else if (length === 4) {

								if (e.keyCode === 191 || e.keyCode === 189 || e.keyCode === 109 || e.keyCode === 111) {

									subStr = value.charAt(3);

									value = value.replace(/\/[0-9]/, '/0' + subStr + '/');

									this.value = value;
								}
							}
						}
					};
				}
			};
		}).
		directive('qtyInput', function () {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:   '<input type="text" data-ng-model="model" data-ng-disabled="disable">',
				scope: {

					'model': '=',
					'disable': '='
				},
				link: function (scope, element, attr) {

					scope.$watch(element);

					element[0].onkeydown = function (e) {

						var value = this.value;

						console.log(e.keyCode);

						// Test if key's pressed are NOT backspace, delete, tab, left window key
						if (e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 9 && e.keyCode !== 91) {

							if (e.keyCode < 37) {

								e.preventDefault();

							} else if (e.shiftKey) {

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

						angular.element(this).attr('placeholder', '1');
					};

					element[0].onblur = function () {

						angular.element(this).removeAttr('placeholder');
					};
				}
			};
		}).
		directive('priceInput', function () {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:   '<input type="text" data-ng-model="model" data-ng-pattern="priceVal" ' +
						'data-ng-disabled="disable">',
				scope: {

					'model': '=',
					'disable': '='
				},
				link: function (scope, element, attr) {

					scope.priceVal = /^[0-9]{0,}[\.]{1,1}([0-9]{2})$/;

					// trailing 0's are being dropped after save, add them back here
					if (scope.model !== null && scope.model.toFixed) {
						scope.model = scope.model.toFixed(2);
					}

					scope.$watch(element);

					element[0].onkeydown = function (e) {

						var value = this.value;

						console.log(e.keyCode);

						// Test if key's pressed are NOT backspace, delete, tab, left window key,
						// period, or decimal point
						if (e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 9 &&
								e.keyCode !== 91 && e.keyCode !== 190 && e.keyCode !== 110) {

							if (e.keyCode < 37) {

								e.preventDefault();

							} else if (e.shiftKey) {

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

						angular.element(this).attr('placeholder', '0.00');
					};

					element[0].onblur = function () {

						angular.element(this).removeAttr('placeholder');
					};
				}
			};
		}).
		directive('datePicker', function () {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template: '<a href="#" data-ng-click="showCalendar($event)" data-ng-model="model" ' +
						'class="iconCalendar calTrigger"></a>',
				scope: {

					'model': '='
				},
				link: function (scope, element, attr) {

					var kalendae = new Kalendae(element[0]);

					scope.$watch(element);
					console.log(element);

					kalendae.subscribe('change', function (date, action) {

								scope.$emit('changeDate', date);
								element.toggleClass('showCal');

								console.log('change');
							}
					);


					scope.showCalendar = function showCalendar(e) {

						e.preventDefault();

						if (event.srcElement.classList.contains('calTrigger')) {

							element.toggleClass('showCal');
						}
					};
				}
			};
		}).
		directive('timeInput', function ($rootScope) {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:   '<input type="text" class="timeInputType" ' +
						'data-ng-model="model" data-ng-pattern="timeVal" data-ng-maxlength="4" ' +
						'data-ng-disabled="disable">',
				scope: {

					'model': '=',
					'disable': '='
				},
				link: function (scope, element, attr) {

					scope.timeVal = /^[0-9]{4}$/;

					scope.$watch(element);

					element[0].onkeydown = function (e) {

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

						angular.element(element[0]).attr('placeholder', 'e.g. 0800');
					};

					element[0].onblur = function () {

						angular.element(element[0]).removeAttr('placeholder');

						if (attr.function) {

							$rootScope.$broadcast(attr.function, true);
						}
					};
				}
			};
		}).
		directive('phoneNumber', function () {

			'use strict';

			return {

				restrict: 'E',
				replace: true,
				template:   '<input type="text" data-ng-disabled="disable" class="phoneInputType" ' +
						'data-ng-model="model" data-ng-pattern="phoneVal" data-ng-maxlength="12">',
				scope: {

					'model': '=',
					'disable': '='
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
			};
		});