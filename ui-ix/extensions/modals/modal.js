$(function () {

	'use strict';

	var $body = $('body'),
		modalOpen = false,
		modalBackgroundPresent = false,
		modalBackground = '<div id="modalBackground" class="hidden"></div>';

	// Open modal
	function openModal (modal, e) {

		if (e) {

			e.preventDefault();
		}

		// Make sure no modals are already open
		if (!modalOpen) {

			// Show the modal
			$(modal).addClass('active');
			modalOpen = true;

		// If there is a modal open, close it
		} else {

			// Close any open modal
			closeModal($('.modal'), e);
			openModal(modal, e);
		}

		// If the background element doesn't exist, append it to the body
		if (!modalBackgroundPresent) {

			// Append the background element to the body
			$body.append(modalBackground);
			modalBackgroundPresent = true;

			// This is required for the CSS animation to trigger the first time
			window.setTimeout(function () {

				$('#modalBackground').removeClass('hidden');
			},0);

		// If the background element does exist, show it
		} else {

			$('#modalBackground').removeClass('hidden');
		}
	}

	// Close modal
	function closeModal ($modal, e) {

		if (e) {

			e.preventDefault();
		}

		// Close any open modal
		$modal.removeClass('active');
		modalOpen = false

		// Hide the background element
		$('#modalBackground').addClass('hidden');
	}

	// Open a modal when clicking on its trigger
	$body.on('click', '.js_modalTrigger', function (e) {

		var modalID = e.target.getAttribute('href');
		openModal(modalID, e);
	});

	// Close a modal when clicking on the close button or the background element
	$body.on('click', '.js_modalClose, #modalBackground', function (e) {

		closeModal($('.modal'), e);
	});

	// Create a global modal property
	PHI.modal = {};

	// Open
	PHI.modal.open = function (modalId) {

		// If the octothorpe is missing, add it
		if (modalId.indexOf('#') === -1) {

			modalId = '#' + modalId;
		}

		// Open the modal.
		openModal(modalId);
	};

	// Close
	PHI.modal.close = function () {

		// Close the modal.
		closeModal($('.modal'));
	};
});
