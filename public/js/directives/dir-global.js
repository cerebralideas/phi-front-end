/************************************\
 * This is the global directives for common form stuff
 */


    // Click Event Delegation
    // This has been adapted from https://github.com/nishp1/angular-delegate-event
    PAS.directive('dgClick', function ($parse) {

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


    PAS.directive('warningRequired', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<div ng-show="" class="info fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong>Required fields:</strong> You have required fields that are still empty.' +
                        '</div>',
            scope: false,
            link: function (scope, element, attr) {

                var form = attr.formCheck;

                attr.$set('ngShow', form + '.$error.required.length > 0');
            }
        };
    });

    PAS.directive('warningPattern', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<div ng-show="" class="alert fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong>Form Error:</strong> There seems to be an error in your form. Please review.' +
                        '</div>',
            scope: false,
            link: function (scope, element, attr) {

                var form = attr.formCheck;

                attr.$set('ngShow', form + '.$error.pattern.length > 0 ||' + form + '.$error.maxlength.length > 0');
            }
        };
    });

    PAS.directive('warningDate', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<div ng-show="invalidDate" class="alert fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong>Invalid Date:</strong> You have a date that is not valid.' +
                        '</div>',
            scope: false
        };
    });

    PAS.directive('dateInput', function ($rootScope, $filter) {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<div class="input"><!--<div class="input-prepend">-->' +
                            '<!--<div class="icon-calendar add-on"></div>-->' +
                            '<input name="{{name}}" ' +
                                    'ng-disabled="disable" type="text" class="dateInputType" id="{{id}}" ' +
                                    'ng-model="model" ng-pattern="dateVal" ng-maxlength="10" ' +
                                    'ng-change="checkIfValid()" required="{{required}}">' +
                        '</div>',
            scope: {

                'required': '@',
                'name': '@',
                'id': '@',
                'model': '=',
                'disable': '='
            },
            link: function (scope, element, attr) {

                scope.dateVal = /^[0-9]{2}[\/]{0,1}[0-9]{2}[\/]{0,1}([0-9]{2}|[0-9]{4})$/;

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

                scope.checkIfValid = function () {

                    var that = angular.element(element).find('input')[0],
                        newEventDateMil,
                        parsedEventDate;

                    if (that.value.length > 6) {

                        newEventDateMil = Date.parse(that.value);
                        parsedEventDate = $filter('date')(newEventDateMil, 'MM/dd/yyyy');

                        console.log(that.value + ' ' + parsedEventDate);

                        if (that.value !== parsedEventDate) {

                            console.log('Your start date is not a valid date');

                            $rootScope.invalidDate = true;

                        } else {

                            console.log('they should be equal');

                            $rootScope.invalidDate = false;

                            $rootScope.$digest();
                        }
                    }
                };

                angular.element(element).find('input')[0].onfocus = function () {

                    var el = angular.element(element).find('input')[0];

                    angular.element(el).attr('placeholder', 'MM/DD/YYYY');
                };

                angular.element(element).find('input')[0].onblur = function () {

                    var value = this.value,
                        el = angular.element(element).find('input')[0],
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

                        } else if (dateArray[2] > (currentYear + 1) && dateArray[2].length === 2) {

                            fourDigitYear = '19' + dateArray[2].toString();

                            this.value = dateArray[0] + '/' + dateArray[1] + '/' + fourDigitYear;
                        }
                    }

                    scope.checkIfValid();

                    angular.element(el).removeAttr('placeholder');
                };

                angular.element(element).find('input')[0].onkeyup = function (e) {

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
    });

    PAS.directive('qtyInput', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<input type="text" ng-model="model" ng-minlength="3">',
            scope: {

                'model': '='
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
    });

    PAS.directive('priceInput', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<input type="text" ng-model="model" ng-pattern="priceVal" ng-minlength="3">',
            scope: {

                'model': '='
            },
            link: function (scope, element, attr) {

                scope.priceVal = /^[0-9]{0,}[\.]{0,1}([0-9]{2})$/;

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
    });

    PAS.directive('timeInput', function () {

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

    PAS.directive('phoneNumber', function () {

        "use strict";

        return {

            restrict: 'E',
            replace: true,
            template:   '<input name="{{name}}" ' +
                            'ng-disabled="disable" type="text" class="phoneInputType" id="{{id}}" ' +
                            'ng-model="model" ng-pattern="phoneVal" ng-maxlength="12" required="{{required}}">',
            scope: {

                'required': '@',
                'name': '@',
                'id': '@',
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