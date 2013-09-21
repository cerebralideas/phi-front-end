(function ($, undefined) {
	'use strict';

	$('body').on("click", ".js_closeAlert", function (e) {

		e.preventDefault();

		$(e.target).parents(".alertBox").addClass('fadeOut');

		setTimeout(function () {

				$(e.target).parents(".alertBox").addClass('hide').removeClass('fadeOut');

			}, 250);
	});

}(jQuery));
