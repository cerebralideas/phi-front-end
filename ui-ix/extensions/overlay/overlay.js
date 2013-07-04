$(function () {

	// Invoke strict mode
	'use strict';

	var $body = $('body'),
		// Create an open overlays array
		openOverlays = [],
		modalBackgroundPresent = false,
		// Define the markup for the modal background element
		modalBackground = '<div id="modalBackground"></div>';

//--------------------------------------//
// Functions to control click behaviour //
//--------------------------------------//

	// e.preventDefault() with extended browser support
	function preventDefault(e) {

		if (e.preventDefault) {

			// e.preventDefault() for modern browsers
			e.preventDefault();

		} else {

			// e.preventDefault() for IE < 9
			e.returnValue = false;
		}
	}

	// e.stopPropagation() with extended browser support
	function stopPropagation(e) {

		if (e.stopPropagation) {

			// e.stopPropagation() for modern browsers
			e.stopPropagation();

		} else {

			// e.stopPropagation() for IE < 9
			e.cancelBubble = true;
		}
	}

//---------------------------------------------------//
// Functions to control the modal background element //
//---------------------------------------------------//

	// Show the modal background element
	function showModalBackground() {

		// If the modal background element doesn't exist, append it to the body
		if (!modalBackgroundPresent) {

			// Append the modal background element to the body
			$body.append(modalBackground);
			modalBackgroundPresent = true;

			// This is required for the CSS animation to trigger the first time
			window.setTimeout(function () {

				// Show the modal background element
				$('#modalBackground').addClass('active');

			}, 0);

		// If the modal background element does exist, show it
		} else {

			// Show the modal background element
			$('#modalBackground').addClass('active');
		}
	}

	// Hide the modal background element
	function hideModalBackground() {

		// Hide the modal background element
		$('#modalBackground').removeClass('active');
	}

//-------------------------------//
// Functions to control overlays //
//-------------------------------//

	// Open overlay
	function openOverlay (overlay, kind, e, target) {

		// Prevent click events if they are present
		if (e) {

			preventDefault(e);
			stopPropagation(e);
		}

		// If the overlay is a modal then show the modal background element
		if (kind === 'modal') {

			showModalBackground();
		}

		// Make sure that no overlay matching the type of the clicked overlay is already open
		if (openOverlays.indexOf(kind) === -1) {

			// Show the overlay
			$(overlay).addClass('active');

			// If the overlay is a dropdown or a popover add an active class to the trigger
			if (kind === 'dropdown' || kind == 'popover') {

				target.addClass('active');
		}

		// Close the current overlay if the trigger is clicked again
		} else if ($(target.attr('href')).hasClass('active')) {

			// Close any open overlay that matched the clicked type
			closeOverlay($('.js_overlay[data-overlay="' + kind + '"]'), kind, e);

			return;

		// If there is an overlay open that matches the type of the clicked overlay, close it
		} else {

			// Close any open overlay that matches the clicked type
			closeOverlay($('.js_overlay[data-overlay="' + kind + '"]'), kind, e);

			// Show the overlay
			openOverlay(overlay, kind, e);
		}

		// If the overlay type isn't already in the open overlays array add it
		if (openOverlays.indexOf(kind) === -1) {

			openOverlays.push(kind);
		}
	}

	// Close overlay
	function closeOverlay ($overlay, kind, e) {

		// Prevent click events if they are present
		if (e) {

			stopPropagation(e);

			if (kind !== null) {

				preventDefault(e);
			}
		}

		// If the overlay is a modal then hide the modal background element
		if (kind === 'modal') {

			hideModalBackground();
		}

		// If the overlay is a dropdown or a popover remove the trigger's active class
		if (kind === 'dropdown' || kind === 'popover' || kind === null) {

			$('.js_overlayTrigger').removeClass('active');
		}

		// Close the overlay
		$overlay.removeClass('active');

		// Remove the overlay type from the open overlays array
		var index = openOverlays.indexOf(kind);
		openOverlays.splice(index, 1);

		// If the body element is clicked, close all overlays
		if (kind === null) {

			openOverlays = [];
		}
	}

//--------------//
// Click events //
//--------------//

	// Open an overlay when clicking on its trigger
	$body.on('click', '.js_overlayTrigger', function (e) {

		// Store the target as a variable
		var target = $(this)

		// Save the kind of overlay as a variable
		var kind = $(target.attr('href')).attr('data-overlay');

		var overlayId = this.getAttribute('href');
		openOverlay(overlayId, kind, e, target);

		// Clear the target variable
		var target = null;
	});

	// Close any modal overlays when clicking on the modal background element
	$body.on('click', '#modalBackground', function (e) {

		closeOverlay($('.js_overlay[data-overlay="modal"]'), 'modal', e);
	});

	// Close contained overlays when clicking on a modal
	$body.on('click', '.js_overlay', function (e) {

	closeOverlay($('.js_overlay[data-overlay="modal"] .js_overlay'), null, e);
	});

	// Close overlay when clicking away from it
	$body.on('click', function (e) {

		closeOverlay($('.js_overlay'), null, e);
	});

//------------------------------------//
// Programmatical control of overlays //
//------------------------------------//

	// Create a global overlay property
	PHI.overlay = {};

	// Open
	PHI.overlay.open = function (overlayId, kind) {

		// If the octothorpe is missing, add it
		if (overlayId.indexOf('#') === -1) {

			overlayId = '#' + overlayId;
		}

		// Open the overlay
		openOverlay(overlayId, kind);
	};

	// Close
	PHI.overlay.close = function (kind) {

		// Close the overlay
		closeOverlay($('.js_overlay'), kind);
	};
});
