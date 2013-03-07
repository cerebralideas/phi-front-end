/* THIS PROVIDES THE SOME OF THE UI AND INTERACTION
 * COMPONENTS FOR THE PAS PROTOTYPE.
 *
 * NOTE: The Twitter Bootstrap JS for Modals,
 * Buttons, Tabs, Tooltip, Popover and Alerts are all
 * within plugins.js.
 *
 * NOTE 2: The dropdown plugin, since it's been altered
 * is below.
 */


(function ($) {

    'use strict';

    // Bind UI components to the respective methods
    PAS.bind.ui($('body'));

    window.onresize = PAS.bind.layout();

}(jQuery));