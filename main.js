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

			// Load Common Angular Components
			'dirComComps': 'framework/directives/dir-common-components',
			'dirComInputs': 'framework/directives/dir-common-inputs',
			'dirEventDel': 'framework/directives/dir-event-delegation',

			// Bower dependencies
			'jquery': '../../vendor-bower/jquery/jquery.min',

			// UI/Ix jQuery framework
			'navigation': 'framework/components/navigation/navigation',
			'overlay': 'framework/components/overlay/overlay',
			'tabs': 'framework/components/tabs/tabs',
			'alerts': 'framework/components/alerts/alerts',
			'datepicker': 'framework/components/date-picker/kalendae',
			'accordion': 'framework/components/accordion/accordion'
		},

		// Declare all dependencies
		shim: {

			// Angular component dependencies
			'dirComComps': ['angular'],
			'dirComInputs': ['angular'],
			'dirEventDel': ['angular'],

			// Phi UI/Ix dependencies
			'navigation': ['jquery'],
			'overlay': ['jquery'],
			'tabs': ['jquery'],
			'alerts': ['jquery'],
			'accordion': ['jquery']
		}
	});

	require(['dirComComps', 'dirComInputs', 'dirEventDel'],

			function () {

				angular.module('phi-demo', ['phi-common-components', 'phi-common-inputs', 'phi-event-delegation']).
						controller('Ctrlr', ['$scope', 'dataService', function ($scope, dataService) {

							$scope.sexes = ['Male', 'Female', 'Other'];

							$scope.states = [

								{value: "AL", text: "Alabama"},
								{value: "AK", text: "Alaska"},
								{value: "AZ", text: "Arizona"},
								{value: "AR", text: "Arkansas"},
								{value: "CA", text: "California"},
								{value: "CO", text: "Colorado"},
								{value: "CT", text: "Connecticut"},
								{value: "DE", text: "Delaware"},
								{value: "DC", text: "District Of Columbia"},
								{value: "FL", text: "Florida"},
								{value: "GA", text: "Georgia"},
								{value: "HI", text: "Hawaii"},
								{value: "ID", text: "Idaho"},
								{value: "IL", text: "Illinois"},
								{value: "IN", text: "Indiana"},
								{value: "IA", text: "Iowa"},
								{value: "KS", text: "Kansas"},
								{value: "KY", text: "Kentucky"},
								{value: "LA", text: "Louisiana"},
								{value: "ME", text: "Maine"},
								{value: "MD", text: "Maryland"},
								{value: "MA", text: "Massachusetts"},
								{value: "MI", text: "Michigan"},
								{value: "MN", text: "Minnesota"},
								{value: "MS", text: "Mississippi"},
								{value: "MO", text: "Missouri"},
								{value: "MT", text: "Montana"},
								{value: "NE", text: "Nebraska"},
								{value: "NV", text: "Nevada"},
								{value: "NH", text: "New Hampshire"},
								{value: "NJ", text: "New Jersey"},
								{value: "NM", text: "New Mexico"},
								{value: "NP", text: "Neehr Perfect"},
								{value: "NY", text: "New York"},
								{value: "NC", text: "North Carolina"},
								{value: "ND", text: "North Dakota"},
								{value: "OH", text: "Ohio"},
								{value: "OK", text: "Oklahoma"},
								{value: "OR", text: "Oregon"},
								{value: "PA", text: "Pennsylvania"},
								{value: "RI", text: "Rhode Island"},
								{value: "SC", text: "South Carolina"},
								{value: "SD", text: "South Dakota"},
								{value: "TN", text: "Tennessee"},
								{value: "TX", text: "Texas"},
								{value: "UT", text: "Utah"},
								{value: "VT", text: "Vermont"},
								{value: "VA", text: "Virginia"},
								{value: "WA", text: "Washington"},
								{value: "WV", text: "West Virginia"},
								{value: "WI", text: "Wisconsin"},
								{value: "WY", text: "Wyoming"}
							];

							$scope.save = function () {

								dataService.save($scope.user);
								$scope.savedData = dataService.get();
							};
						}]);

				angular.bootstrap(document, ['phi-demo']);
			}
	);

	// Load in jQuery plugins
	require(['navigation', 'overlay', 'tabs', 'alerts', 'datepicker', 'accordion'],

			function (navigation, overlay, tabs, alerts, datepicker, accordion) {

				// Kalendae plugin initialization
				$('body').on('click.useCalendar', '.useCalendar', function () {

					console.log('hello');

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
