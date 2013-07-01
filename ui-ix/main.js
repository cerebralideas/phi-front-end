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
			'overlay': '/phi/ui-ix/extensions/overlay/overlay',
			'tabs': '/phi/ui-ix/extensions/tabs/jquery.foundation.tabs',
			'alerts': '/phi/ui-ix/extensions/alerts/jquery.foundation.alerts',
			'core': '/phi/ui-ix/core/core'
		},

		// Declare all dependencies
		shim: {

			// Angular file dependencies
			'app': ['angular'],

			// Phi UI/Ix dependencies
			'overlay': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery'],
			'custom': ['jquery'],
			'core': ['jquery']
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
			['overlay', 'tabs', 'alerts', 'core'],

			function (overlay, tabs, alerts, custom, core) {

				// Do stuff :)
			}
	);
}());
