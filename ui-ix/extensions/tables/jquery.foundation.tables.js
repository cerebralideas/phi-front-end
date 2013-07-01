/*
 * jQuery Responsive Table Plugin
 * www.ZURB.com
 * Copyright 2010, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

/* THIS IS CURRENTLY BREAKING THINGS ON iOS */

;$(function() {

	'use strict';

	var switched = false,
		tables = $('.js_tableResponsive'),
		splitTable = function splitTable(original) {

			var copy;

			original.wrap('<div class="table-wrapper" />');

			copy = original.clone();
			copy.find('td:not(:first-child), th:not(:first-child)').css('display', 'none');
			copy.removeClass();

			original.closest('.table-wrapper').append(copy);

			copy.wrap('<div class="pinned" />');

			original.wrap('<div class="scrollable" />');
		},
		unsplitTable = function unsplitTable(original) {

			original.closest('.table-wrapper').find('.pinned').remove();
			original.unwrap();
			original.unwrap();
		},
		updateTables = function updateTables() {

			if (($(window).width() < 767) && !switched ) {

				switched = true;

				tables.each(function(i, element) {

					splitTable($(element));
				});

				return true;

			} else if (switched && ($(window).width() > 767)) {

				switched = false;

				tables.each(function(i, element) {

					unsplitTable($(element));
				});
			}
		};

	$(window).load(updateTables());
	$(window).on('resize', updateTables);

});
