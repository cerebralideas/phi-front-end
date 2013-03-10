PHI.service('dataService', function () {

	var data = {};

	this.set = function (stuff) {

		data = stuff;
	};
	this.get = function () {

		return data;
	}
});

