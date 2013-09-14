$(function () {

	/* GLOBAL DROP-DOWN FUNCTIONALITY: This creates the drop-down functionality
	 * for hidden sub-menus.
	 */

	/* This deactivates the fallback Suckerfish drop-down (if there is one),
	 * creates the drop-down functionality for hidden sub-menus using jQuery.
	 */

	var $nav = $('.dropDownMenu'),
		$navItem = $nav.find('.navItem'),
		downArrow = '<i>&#x25be;</i>', // creates HTML arrow
		upArrow = '<i>&#x25b4;</i>', // creates HTML arrow
		arrow,
		dropDown;

	$nav.removeClass('hasHover'); // Removes fallback CSS dropdown

	console.log('hello');

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

				dropDown.slideUp(100);
				dropDown.parent().find(arrow).html(downArrow).removeClass('open');
			}

			subMenu = $(this).parent().find(dropDown);

			if ( subMenu.is(':hidden')) {

				subMenu.slideDown(200);
				subMenu.parent().find(arrow).html(upArrow).addClass('open');

			} else {

				subMenu.slideUp(100);
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
			subMenu.slideDown(400);
			subMenu.parent().find(arrow).html(upArrow).addClass('open');

		});

		// If focused is lost on drop-down trigger slide up menu
		// This should be written better

		$nav.find('a').parent().delegate(".dropDown li:last-child a", "blur", function () {

			var subMenu = $(this).parent().parent(dropDown);
			subMenu.slideUp(100);
			subMenu.parent().find(arrow).html(downArrow).removeClass('open');

		});

		// If user clicks on any element while drop-down is visible, slideUp menu

		$('body').click(function () {

			if (dropDown.is(':visible')) {

				dropDown.slideUp(100);
				dropDown.parent().find(arrow).html(downArrow).removeClass('open');

			}
		});
	}
}());
