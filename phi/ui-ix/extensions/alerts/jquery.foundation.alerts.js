(function ($, window, undefined) {
	'use strict';

	$('body').on("click", ".js_closeAlert", function (e) {

		console.log('click on me');

		e.preventDefault();

		$(e.target).parents(".alertBox").fadeOut(function () {

			$(this).remove();
		});
	});

})(jQuery, this);
