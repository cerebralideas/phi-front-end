PHI.service('dataService', function () {

	var data = {};

	this.save = function (stuff) {

		data = stuff;
	};
	this.get = function () {

		return data;
	}
});

