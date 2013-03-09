PHI.directive('warningRequired', function () {

	"use strict";

	return {

		restrict: 'E',
		replace: true,
		template:   '<div ng-show="" class="alertBox alert">' +
						'<p><strong>Required fields:</strong> You have one or more required fields that are still ' +
								'empty.</p>' +
						'<a href="" class="js_closeAlert close">&#x2613;</a>' +
					'</div>',
		scope: false,
		link: function (scope, element, attr) {

			var form = attr.formCheck;

			attr.$set('ngShow', form + '.$error.required.length > 0');
		}
	};

}).directive('warningPattern', function () {

	"use strict";

	return {

		restrict: 'E',
		replace: true,
		template:   '<div ng-show="" class="alertBox alert">' +
						'<p><strong>Form Error:</strong> There seems to be a formatting error in your form. ' +
								'Please review.</p>' +
						'<a href="" class="js_closeAlert close">&#x2613;</a>' +
					'</div>',
		scope: false,
		link: function (scope, element, attr) {

			var form = attr.formCheck;

			attr.$set('ngShow', form + '.$error.pattern.length > 0 ||' + form + '.$error.maxlength.length > 0');
		}
	};

}).directive('warningDate', function () {

	"use strict";

	return {

		restrict: 'E',
		replace: true,
		template:   '<div ng-show="invalidDate" class="alertBox alert">' +
						'<p><strong>Invalid Date:</strong> You have a date that is not valid.</p>' +
						'<a href="" class="js_closeAlert close">&#x2613;</a>' +
					'</div>',
		scope: false
	};
});