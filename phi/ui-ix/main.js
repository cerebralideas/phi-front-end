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

			// Load Angular
			'angular': '../../vendor-bower/angular/angular.min',

			// Load app module
			'app': '../app/app',

			// Bower dependencies
			'jquery': '../../vendor-bower/jquery/jquery.min',

			// UI/Ix jQuery framework
			'navigation': '/phi/ui-ix/extensions/navigation/navigation',
			'overlay': '/phi/ui-ix/extensions/overlay/overlay',
			'tabs': '/phi/ui-ix/extensions/tabs/tabs',
			'alerts': '/phi/ui-ix/extensions/alerts/alerts',
			'datepicker': '/phi/ui-ix/extensions/date-picker/kalendae',
			'accordion': '/phi/ui-ix/extensions/accordion/accordion'
		},

		// Declare all dependencies
		shim: {

			// Angular file dependencies
			'app': ['angular'],

			// Phi UI/Ix dependencies
			'navigation': ['jquery', 'app'],
			'overlay': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery'],
			'accordion': ['jquery']
		}
	});

	require(
			['app'],

			function () {

				angular.bootstrap(document, ['PHI']);
			}
	);

	// Load in jQuery plugins
	require(
			['navigation', 'overlay', 'tabs', 'alerts', 'datepicker', 'accordion'],

			function (navigation, overlay, tabs, alerts, datepicker, accordion) {

				// Kalendae plugin initialization
				$('body').on('click.useCalendar', '.useCalendar', function () {

					console.log('clicked!');

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
