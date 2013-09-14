(function () {

	'use strict';

	/************************************************************
	 * Load Javascripts Asynchronously **************************
	 ************************************************************/

		// Create global var for attaching PHI modules.
	window.PHI = {};

	requirejs.config({

		// Map out all "modules" to paths
		paths: {

			// Bower dependencies
			'jquery': '/vendor-bower/jquery/jquery.min',

			// UI/Ix jQuery framework
			'modal': '/phi/ui-ix/extensions/modals/modal',
			'tabs': '/phi/ui-ix/extensions/tabs/jquery.foundation.tabs',
			'alerts': '/phi/ui-ix/extensions/alerts/jquery.foundation.alerts'
		},

		// Declare all dependencies
		shim: {
			'modal': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery']
		}
	});

	// Load in jQuery plugins
	require(
			['modal', 'tabs', 'alerts'],

			function (modal, tabs, alerts, custom) {

				// Kalendae plugin initialization
				$doc.on('click.useCalendar', '.useCalendar', function () {

					var parent = this.parentNode,
							input = parent.getElementsByTagName('input')[0],
							$input = $(input);

					if (!($input.hasClass('hasCalendar'))) {

						new Kalendae.Input(input, {
							attachTo: input
						});

						$input.focus().addClass('hasCalendar');

					} else {

						$input.focus();
					}
				});
			}
	);
}());
