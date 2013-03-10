PHI.service('dataServices', function ($http) {

	'use strict';

	// Now, create our Constructor function
	var ModifyData = function ModifyData() {

		// We first test to see if the newly created object
		// is an instance of this Constructor. In other words,
		// test if the *new* keyword was used.
		if (!(this instanceof ModifyData)) {

			// If it isn't, then we write a warning out to
			// the console …
			console.log('Warning: Constructor function "User" should be used with the "new" operator.');

			// … and fix the issue
			return new ModifyData();
		}

		return this;
	};

	ModifyData.prototype = {

		save: function saveService(url, data) {

			return $http.post(url, data).

					success(function (data, status) {

						console.log('Status code ' + status + ': saving of data was successful :)');

					}).error(function (data, status) {

						console.log('Status code ' + status + ': saving of data was unsuccessful :(');
					});
		},

		query: function queryService(url) {

			return $http.get(url).

					success(function (data, status) {

						console.log('Status code ' + status + ': querying of data was successful :)');

					}).error(function (data, status) {

						console.log('Status code ' + status + ': querying of data was unsuccessful :(');
					});
		}
	};

	this.fn = new ModifyData();
});