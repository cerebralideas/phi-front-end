/**
 * LAYOUT FUNCTION FOR ENSURING A PROPER LAYOUT
 *
 * Author: Justin Lowery
 * Date: 7/25/12
 * Time: 9:09 PM
 */

PAS.bind.layout = function sizeLayout () {

    'use strict';

    var $ = jQuery,
        supportPanel = document.getElementById('supportContent'),
        mainPanel = document.getElementById('mainPanel'),
        mainTabContainer = $(mainPanel).find('.content'),
        contentSectionPxTop = $(mainTabContainer).offset(),
        bodyHeight = $('body').outerHeight(),
        neededContentHeight = bodyHeight - contentSectionPxTop.top,
        mainTabHeight;

    $(mainTabContainer).css('height', neededContentHeight);

    mainTabContainer = $(mainPanel).find('.content');
    mainTabHeight = $(mainTabContainer).outerHeight();

    $(supportPanel).css('height', mainTabHeight);
};

// Run the size layout function
PAS.bind.layout();