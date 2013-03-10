PHI.service('objectServices', function ($http) {

	'use strict';

	// Now, create our Constructor function
	var ModifyObjects = function ModifyObjects() {

		// We first test to see if the newly created object
		// is an instance of this Constructor. In other words,
		// test if the *new* keyword was used.
		if (!(this instanceof ModifyObjects)) {

			// If it isn't, then we write a warning out to
			// the console …
			console.log('Warning: Constructor function "User" should be used with the "new" operator.');

			// … and fix the issue
			return new ModifyObjects();
		}

		return this;
	};

	// Create our prototype as usual
	ModifyObjects.prototype = {

		constructor: ModifyObjects,

		bulkModify: function BulkModifyObjects(param) {

			// param: action, property, value, items

			var items = param.items,
				property = param.property,
				value = param.value,
				item,
				iter = 0,
				prop;

			for (iter; iter < items.length; iter = iter + 1) {

				item = items[iter];

				if (param.action === 'selectAll') {

					for (prop in item) {

						if (item.hasOwnProperty(prop) && item[prop] === property) {

							// console.log(item + ' has ' + prop + ' with value ' + property);

							item.selected = value;
						}
					}
				} else if (item.selected === true) {

					item.subStatus = value;
					item.selected = false;

					console.log(item.subId);

					this.update(item.subId, value);
				}
			}
		},

		modify: function ModifyObjects(param) {

			// param: action, property, value, items

			var items = param.items,
				property = param.property,
				value = param.value,
				item = param.item,
				iterItem,
				iter = 0;

			if (typeof item === 'number') {

				for (iter; iter < items.length; iter = iter + 1) {

					iterItem = items[iter];

					if (iterItem.subId === item) {

						console.log(iterItem.subId);

						iterItem.subStatus = value;

						this.update(iterItem.subId, value);
					}
				}
			} else if (item.selected === true && property === 'subStatus') {

				item.subStatus = value;
				item.selected = false;

				this.update(item.subId, value);

			} else if (!(item.selected) || item.selected === false) {

				for (iter; iter < items.length; iter = iter + 1) {

					iterItem = items[iter];

					iterItem.selected = false;
				}

				item.selected = true;
			}
		},

		update: function UpdateObjects(id, url, value) {

			return $http.post(url).
					success(function (data, status) {

						console.log('Status code ' + status + ' Item ' + id +
								' has been updated on the server.');

					}).error(function (data, status) {

						console.log('Status code ' + status + ' Item ' + id +
								' had an error while updating server.');
					});
		}
	};

	this.fn = new ModifyObjects();
});