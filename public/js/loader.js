/**
 * THIS LOADS ALL THE FOOTER JAVASCRIPT COMPONENTS
 *
 * Author: Justin Lowery
 * Date: 7/25/12
 * Time: 6:14 PM
 */

Modernizr.load([
    {
        load: 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js',
        complete: function () {

            'use strict';

            // Load jQuery dependent scripts
            Modernizr.load([

                // Third party concatenated file
                '/js/plugins-thirdparty/dev/thirdparty.concat.js',

                // Custom plugins concatenated file
                '/js/plugins-custom/dev/custom.concat.js',

                // Final non-plugin scripts
                '/js/script.js'
            ]);
        }
    }
]);