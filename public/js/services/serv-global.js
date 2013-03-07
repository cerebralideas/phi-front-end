
/***************************************************
 * LET'S CREATE THE GLOBAL SERVICES FOR PAS
 */


    /************************************\
     * "dataServices" provides the services for data management between the
     * server and the client.
     */


        PAS.service('dataServices', function ($http) {

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

                save: function saveService(type, value) {

                    var url = '/' + type.toLowerCase() + 'async/save' + type.toLowerCase();

                    if (type === 'masterFlag') {

                        url = '/preferencesasync/setmasterdataflag?flag=' + value;
                    }

                    console.log(url);
                    console.log(DATA[type]);

                    return $http.post(url, DATA[type]).

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
                },

                register: function registerService(type) {

                    // Use the save function above for code reuse.
                    this.save(type).then(function (value) {

                        var patientId = parseInt(value.data, 10);

                        window.location = '/patients/patient?patientId=' + encodeURIComponent(patientId) +
                                '&origin=register&stage=edit&data=patient-info&searchTerms=';
                    });
                },

                submit: function submitService(array, type) {

                    var url = '/signasync/submit';

                    return $http.post(url, array).

                            success(function (data, status) {

                                var subId = parseInt(data, 10);

                                if (subId > 0) {

                                    console.log('All is well.  Item submitted successfully');

                                    DATA.sns.badSig = false;

                                } else {

                                    console.log('Your eSig was not incorrect. Please try again.');

                                    DATA.sns.badSig = true;
                                }

                            }).error(function (data, status) {

                                console.log('Status code ' + status + ': submission of data was unsuccessful :(');
                            });
                }
            };

            this.fn = new ModifyData();
        });


    /************************************\
     * "objectServices" provides the services for object management within the client.
     */


        PAS.service('objectServices', function ($http) {

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

                update: function UpdateObjects(id, value) {

                    var url = '/activityasync/changesubmissionstatus?subId=' + id + '&subStatus=' + value;

                    console.log(url);

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

        // Move forward in the unit of time
        PAS.service('dateMgmt', function ($http) {

            "use strict";

            this.move = function moveDate(url) {

                return $http.get(url).

                        success(function (data, status) {

                            console.log('Status code ' + status + ': retrieving event data was successful :)');

                        }).error(function (data, status) {

                            console.log('Status code ' + status + ': retrieving event data was unsuccessful :(');
                        });
            };
        });