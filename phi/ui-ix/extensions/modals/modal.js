$(function () {

	'use strict';

	// If triggered, don't re-trigger
	var modalTriggered = false,
		modalBgPresent = false,
	    $document = $(document);

	// Open function
	function openModal(modal, e) {

		var modalBg = '<div class="modalBg"></div>',
			$modalBg = null,
			$modal = $(modal);

		if (e) {

			e.preventDefault();
		}

		// Check if triggered
		if (modalTriggered) {

			// Do nothing as it has already been triggered
			return false;

		} else {

			// set to triggered state
			modalTriggered = true;
		}

		if (modalBgPresent) {

			// Do nothing

		} else {

			// Append modal background
			$('body').append(modalBg);
			modalBgPresent = true;
		}

		// Cache the modal bg
		$modalBg = $('.modalBg').addClass('displayModalBg');

		// Display modal
		$modal.addClass('displayModal');

		// setTimeout to animate modal
		window.setTimeout(function () {
				$modalBg.addClass('animateModalBg');
				$modal.addClass('animateModal');
			}, 0
		);
	}

	function closeModal($modal, e) {

		if (e) {

			e.preventDefault();
		}

		var $modalBg = $('.modalBg');

		$modal.removeClass('animateModal');
		$modalBg.removeClass('animateModalBg');

		window.setTimeout(function () {
				$modal.removeClass('displayModal');
				$modalBg.removeClass('displayModalBg');

				modalTriggered = false;
			}, 450
		);
	}

	// Bind click event to .modalTrigger class by delegation
	$document.on('click', '.modalTrigger', function (e) {

		var modalId = $( this ).attr( 'data-modal-id' );

		// Open the modal.
		openModal('#' + modalId, e);
	});

	$document.on('click', '.modalBg', function (e) {

		// Close the modal.
		closeModal($('.displayModal'), e);
	});

	$document.on('click','.js_closeModal', function (e) {

		// close the modal.
		closeModal($('.displayModal'), e);
	});

	// create global modal property
	PHI.modal = {};

	PHI.modal.open = function (modalId) {

		if (modalId.indexOf('#') === -1) {

			modalId = '#' + modalId;
		}

		// close the modal.
		openModal(modalId);
	};

	PHI.modal.close = function () {

		// close the modal.
		closeModal($('.displayModal'));
	};
});