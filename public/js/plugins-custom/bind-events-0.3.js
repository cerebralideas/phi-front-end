/**
 * BINDS UI COMPONENTS TO METHODS
 *
 * Note: This can be called multiple times at any time.
 * All you need to do is pass in the container of the DOM
 * that needs to be rebound. This ensures that we don't
 * rebind the entire DOM needlessly if you do some AJAXy
 * goodness.
 *
 * Just run this function after an AJAX event with the
 * container of what changed passed as an argument.
 *
 * User: jlowery
 * Date: 7/25/12
 * Time: 3:52 PM
 */

PAS.bind.ui = function eventsDotBind($container) {

    'use strict';

    var $ = jQuery,
        tooltipTriggers;

    if (!($container instanceof jQuery)) {

        $container = $($container);
    }

    tooltipTriggers = $container.find('.tooltip-trigger');

    tooltipTriggers.tooltip();
};