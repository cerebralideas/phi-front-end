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
			'overlay': '/phi/framework/components/overlay/overlay',
			'tabs': '/phi/framework/components/tabs/.tabs',
			'alerts': '/phi/framework/components/alerts/alerts'
		},

		// Declare all dependencies
		shim: {
			'overlay': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery']
		}
	});

	// Load in jQuery plugins
	require(
			['overlay', 'tabs', 'alerts'],

			function (overlay, tabs, alerts, custom) {

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
