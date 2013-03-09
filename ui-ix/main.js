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
				'../../vendor/angularjs/angular.js',
				'../app/app.js'

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

				// Load depe../ndents
				'../../vendor/jquery/full/jquery.js',

				// Load extensions
				'extensions/navigation/phi.navigation.js',
				'extensions/tabs/jquery.foundation.tabs.js',
				'extensions/modals/jquery.foundation.reveal.js',
				'extensions/wayfinder/jquery.waypoints.js',
				'extensions/alerts/jquery.foundation.alerts.js',
				'extensions/date-picker/kalendae.js',

				// Load core js
				'core/core.js'
			]
		}
	]);
}());
