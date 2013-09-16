(function ($, undefined) {
	'use strict';

	$('body').on("click", ".js_closeAlert", function (e) {

		e.preventDefault();

		$(e.target).parents(".alertBox").fadeOut();
	});

}(jQuery));
