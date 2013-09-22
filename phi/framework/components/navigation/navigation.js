$(function ($, undefined) {

	/* GLOBAL DROP-DOWN FUNCTIONALITY: This creates the drop-down functionality
	 * for hidden sub-menus.
	 */

	/* This deactivates the fallback Suckerfish drop-down (if there is one),
	 * creates the drop-down functionality for hidden sub-menus using jQuery.
	 */

	'use strict';

	// TODO: Rethink how bindNav() is run.

	(function checkNavLoaded () {

		console.log('Running checkNavLoaded');

		if ( $('.dropDownMenu').length !== 0 ) {

			console.log('Loaded!');

			bindNav();

		} else {

			setTimeout(checkNavLoaded, 200);
		}
	}());

	function bindNav () {

		console.log($('.dropDownMenu'));

		var $nav = $('.dropDownMenu'),
			$navItem = $nav.find('.navItem'),
			downArrow = '<i>&#xe0ca;</i>', // creates HTML arrow
			upArrow = '<i>&#xe0cb;</i>', // creates HTML arrow
			arrow,
			dropDown;

		$nav.removeClass('hasHover'); // Removes fallback CSS dropdown

		if ($navItem.find('ul') || $navItem.find('ol')) {

			$navItem.find('ul').addClass('dropDown').
					parent().addClass('hasDropdown').
					children('a').after('<span class="dropDownTrigger">' +
					'<a class="disclosureArrow" tabindex="-1" title="Opens a drop-down Menu for sub-menu" ' +
					'href="#">' + downArrow + '</a></span>'
				);

			$navItem.find('ol').addClass('dropDown').
					parent().addClass('hasDropdown').
					children('a').after('<span class="dropDownTrigger">' +
					'<a class="disclosureArrow" tabindex="-1" title="Opens a drop-down Menu for sub-menu" ' +
					'href="#">' + downArrow + '</a></span>'
				);

			dropDown =  $('.dropDown');
			arrow = $navItem.find('.disclosureArrow');

			$nav.on('click', '.dropDownTrigger', function (e) {

				var parentWidth = $(this).parent().innerWidth(),
					subMenu;

				if (dropDown.is(':visible')) {

					dropDown.parent().find(arrow).html(downArrow).removeClass('open');
				}

				subMenu = $(this).parent().find(dropDown);

				if ( subMenu.is(':hidden')) {

					subMenu.parent().find(arrow).html(upArrow).addClass('open');

				} else {

					subMenu.parent().find(arrow).html(downArrow).removeClass('open');

				}

				// TODO: Would rather not have to do return: false, but
				// this unfortunately is needed to keep the click event
				// on the body below from pulling the menu back up.
				return false;
			});

			/* This improves accessibility by triggering the drop-down if
			 the user focuses on the main level element; only works if
			 screen reader uses JS
			 */

			$nav.find('a').focus(function () {

				var subMenu = $(this).parent('li').find('.dropDown');
				subMenu.parent().find(arrow).html(upArrow).addClass('open');

			});

			// If focused is lost on drop-down trigger slide up menu
			// This should be written better

			$nav.find('a').parent().delegate(".dropDown li:last-child a", "blur", function () {

				var subMenu = $(this).parent().parent(dropDown);
				subMenu.parent().find(arrow).html(downArrow).removeClass('open');

			});

			// If user clicks on any element while drop-down is visible, slideUp menu

			$('body').click(function () {

				if (dropDown.is(':visible')) {

					dropDown.parent().find(arrow).html(downArrow).removeClass('open');

				}
			});
		}
	}
}(jQuery));
