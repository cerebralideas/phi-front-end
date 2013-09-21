/*! phi-front-end | Version: 1.0.0 | Concatenated on 2013-09-21 */

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
			'tabs': '/phi/framework/components/tabs/tabs',
			'alerts': '/phi/framework/components/alerts/alerts',
			'core': '/phi/framework/core/core'
		},

		// Declare all dependencies
		shim: {
			'overlay': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery'],
			'custom': ['jquery'],
			'core': ['jquery']
		}
	});

	// Load in jQuery plugins
	require(
			['overlay', 'tabs', 'alerts', 'core'],

			function (overlay, tabs, alerts, custom, core) {

				// Do stuff :)
			}
	);
}());
