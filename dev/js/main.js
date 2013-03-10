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
				// Load AngularJS and dependents
				'vendor/angularjs/angular.js',
				'phi/app/app.js'

				// Load controllers

				// directives

				// services

				// filters

			],
			complete: function () {

				// When all the Angular scripts have executed, bootstrap the app
				angular.bootstrap(document, ['PHI']);
			}
		},
		{
			// Load UI and Ix Scripts
			load: [

				// Load dependents
				'vendor/jquery/full/jquery.js',

				// Load extensions
				'phi/ui-ix/extensions/navigation/phi.navigation.js',
				'phi/ui-ix/extensions/tabs/jquery.foundation.tabs.js',
				'phi/ui-ix/extensions/modals/jquery.foundation.reveal.js',
				'phi/ui-ix/extensions/wayfinder/jquery.waypoints.js',
				'phi/ui-ix/extensions/alerts/jquery.foundation.alerts.js',
				'phi/ui-ix/extensions/date-picker/kalendae.js',

				// Load core js
				'phi/ui-ix/core/core.js'
			]
		}
	]);
}());
