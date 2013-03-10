/************************************************************
 * Initialize Foundation JavaScripts ************************
 ************************************************************/

$(document).ready(function() {

	var $doc = $(document),
		$waypointsContainer = $('.js_waypoints'),
		$waypointNav = $('.js_waypointNav'),
		$waypoints = $waypointsContainer.children('div, li, dd');

	$.fn.foundationAlerts ? $doc.foundationAlerts() : null;
	$.fn.foundationButtons ? $doc.foundationButtons() : null;
	$.fn.foundationAccordion ? $doc.foundationAccordion() : null;
	$.fn.foundationNavigation ? $doc.foundationNavigation() : null;
	$.fn.foundationTopBar ? $doc.foundationTopBar() : null;
	$.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
	$.fn.foundationTabs ? $doc.foundationTabs() : null;
	$.fn.foundationTooltips ? $doc.foundationTooltips() : null;
	$.fn.foundationClearing ? $doc.foundationClearing() : null;

	$.fn.placeholder ? $('input, textarea').placeholder() : null;

	// Waypoints plugin initialization
	$.fn.waypoint ? $waypoints.waypoint({
		context: $waypointsContainer,
		handler: function(event, direction) {

			$active = $(this);

			if (direction === "up") {
				$active = $active.prev();
			}
			if (!$active.length) {
				$active = $active.end();
			}

			$waypointsContainer.find('.section-active').removeClass('section-active');
			$active.addClass('section-active');

			$waypointNav.find('.active').removeClass('active');
			$waypointNav.find('a[href=#'+$active.attr('id')+']').parent('li').addClass('active');
		}
	}) : null;

	// Kalendae plugin initialization
	$doc.on('click.useCalendar', '.useCalendar', function () {

		var parent = this.parentNode,
			input = parent.getElementsByTagName('input')[0],
			$input = $(input);

		if (!($input.hasClass('hasCalendar'))) {

			new Kalendae.Input(input, {
				attachTo: input
			});

			$input.focus().addClass('hasCalendar');

		} else {

			$input.focus();
		}
	});
});

// Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
if (Modernizr.touch && !window.location.hash) {
	$(window).load(function () {
		setTimeout(function () {
			window.scrollTo(0, 1);
		}, 0);
	});
}