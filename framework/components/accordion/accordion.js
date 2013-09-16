(function ($, undefined){

	'use strict';

	$('body').on('click.acc', '.accordion > li', function () {

		var that = $(this),
			parent = that.parent(),
			panel = that.find('.content');

		if (that.hasClass('active')) {

			panel.slideUp(250);
			that.removeClass('active');

		} else {

			parent.find('.active').removeClass('active').find('.content').slideUp();

			panel.slideDown(250);
			that.addClass('active');
		}
	});
}(jQuery));
