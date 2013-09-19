(function ($, undefined){

	'use strict';

	$('body').on('click.acc', '.accordion > li', function () {

		var that = $(this),
			parent = that.parent();

		if (that.hasClass('active')) {

			that.removeClass('active');

		} else {

			parent.find('.active').removeClass('active');

			that.addClass('active');
		}
	});
}(jQuery));
