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
			'modal': '/phi/ui-ix/extensions/modals/modal',
			'tabs': '/phi/ui-ix/extensions/tabs/jquery.foundation.tabs',
			'alerts': '/phi/ui-ix/extensions/alerts/jquery.foundation.alerts',
			'core': '/phi/ui-ix/core/core'
		},

		// Declare all dependencies
		shim: {

			// Angular file dependencies
			'app': ['angular'],

			// Phi UI/Ix dependencies
			'modal': ['jquery'],
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
			['modal', 'tabs', 'alerts', 'core'],

			function (modal, tabs, alerts, custom, core) {

				// Do stuff :)
			}
	);
}());
