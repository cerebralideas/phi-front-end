
/***************************************************
 * LET'S CREATE THE PATIENTS SERVICES!
 *
 */


PAS.service('ptServices', function () {

    "use strict";

    this.calcAge = function calcAgeService(bDate) {

        var today = new Date(),
            bDateMil = Date.parse(bDate),
            age;

        age = today - bDateMil;

        age = age / 3.15569e10;

        if (age > 1) {

            age = (Math.floor(age)) + " y.o.";

        } else {

            age = (Math.floor(12 * age)) + " m.o.";
        }

       return age;
    };
});