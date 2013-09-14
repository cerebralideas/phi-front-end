(function ($, window, document, undefined) {

	'use strict';

	function setTab(href, e) {

		console.log(href);

		var newTab = $(e.target).parent(),
			oldTab = newTab.parents('.tabs').find('.active');

		console.log(newTab);
		console.log(oldTab);

		// Show tab content
		e.preventDefault();
		$(href).parents('.tabsContent').find('li').removeClass('active').end().
				find(href).addClass('active');

		// Make active tab
		oldTab.removeClass('active');
		newTab.addClass('active');
	}

	$('body').on('click', '.tab a', function (e) {

		setTab($(e.target).attr('href'), e);
	});

}(jQuery, this, this.document));
