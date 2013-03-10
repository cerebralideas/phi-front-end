(function () {

	'use strict';

	/************************************************************
	 * Ensures console object is usable on non-console browsers *
	 ************************************************************/

	var method,
		noop = function noop() {},
		methods = [
			'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
			'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
			'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
			'timeStamp', 'trace', 'warn'
		],
		length = methods.length,
		console = (window.console = window.console || {});

	while (length--) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}

	/************************************************************
	 * Load Javascripts Asynchronously **************************
	 ************************************************************/

	// Load Angular Scripts
	Modernizr.load([
		{
			load: [
				'../../vendor/angularjs/angular.js',
				'app.js',

				// Load controllers
				'controllers/example-form.js',

				// directives
				'directives/dir-common-warnings.js',
				'directives/dir-date-input.js',
				'directives/dir-event-delegation.js',
				'directives/dir-phone-input.js',
				'directives/dir-time-input.js',

				// services
				'services/srv-data.js'

				// filters

			],
			complete: function () {

				// When all the Angular scripts have executed, bootstrap the app
				angular.bootstrap(document, ['PHI']);
			}
		}
	]);

	// Load UI and Ix Scripts
	Modernizr.load([
		{
			load: [

				// Load dependents
				'../../vendor/jquery/full/jquery.js',

				// Load extensions
				'../ui-ix/extensions/navigation/phi.navigation.js',
				'../ui-ix/extensions/tabs/jquery.foundation.tabs.js',
				'../ui-ix/extensions/modals/jquery.foundation.reveal.js',
				'../ui-ix/extensions/wayfinder/jquery.waypoints.js',
				'../ui-ix/extensions/alerts/jquery.foundation.alerts.js',
				'../ui-ix/extensions/date-picker/kalendae.js',

				// Load core js
				'../ui-ix/core/core.js'
			]
		}
	]);
}());
