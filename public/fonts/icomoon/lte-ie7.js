/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-home' : '&#x2617;',
			'icon-folder' : '&#x2b13;',
			'icon-support' : '&#x2706;',
			'icon-tag' : '&#x275a;',
			'icon-play' : '&#x25b8;',
			'icon-drawer' : '&#x2b12;',
			'icon-search' : '&#x26b2;',
			'icon-dashboard' : '&#x2687;',
			'icon-equalizer' : '&#x2692;',
			'icon-key' : '&#x6c;',
			'icon-remove' : '&#x2326;',
			'icon-eye' : '&#x25c9;',
			'icon-flag' : '&#x61;',
			'icon-info' : '&#x69;',
			'icon-help' : '&#x2370;',
			'icon-file-pdf' : '&#x70;',
			'icon-grid-view' : '&#x268f;',
			'icon-cog' : '&#x2638;',
			'icon-paper' : '&#x25a2;',
			'icon-user' : '&#x265f;',
			'icon-users' : '&#x2659;',
			'icon-warning' : '&#x26a0;',
			'icon-loading' : '&#x293e;',
			'icon-clipboard' : '&#x2630;',
			'icon-printer' : '&#x50;',
			'icon-dots-three' : '&#x268b;',
			'icon-record' : '&#x25cf;',
			'icon-clock' : '&#x2686;',
			'icon-flag-2' : '&#x2691;',
			'icon-calendar' : '&#x2631;',
			'icon-install' : '&#x2913;',
			'icon-chat' : '&#x51;',
			'icon-comment' : '&#x71;',
			'icon-card' : '&#x25a4;',
			'icon-export' : '&#x2348;',
			'icon-email' : '&#x2709;',
			'icon-write' : '&#x270e;',
			'icon-reply' : '&#x27f2;',
			'icon-forward' : '&#x27f3;',
			'icon-none' : '&#x6e;',
			'icon-move-horizontal' : '&#x27f7;',
			'icon-fullscreen-exit-alt' : '&#x25fe;',
			'icon-fullscreen-alt' : '&#x25fc;',
			'icon-arrow' : '&#x2190;',
			'icon-arrow-2' : '&#x2193;',
			'icon-arrow-3' : '&#x2191;',
			'icon-arrow-4' : '&#x2192;',
			'icon-arrow-left-alt1' : '&#x2b05;',
			'icon-arrow-right-alt1' : '&#x27a1;',
			'icon-arrow-up-alt1' : '&#x2b06;',
			'icon-arrow-down-alt1' : '&#x2b07;',
			'icon-arrow-5' : '&#x2195;',
			'icon-checkmark' : '&#x2713;',
			'icon-check-alt' : '&#x2611;',
			'icon-x' : '&#x2715;',
			'icon-x-altx-alt' : '&#x2612;',
			'icon-denied' : '&#x2349;',
			'icon-plus' : '&#x2b;',
			'icon-plus-alt' : '&#x271a;',
			'icon-minus' : '&#x2d;',
			'icon-minus-alt' : '&#x25ac;',
			'icon-move-alt2' : '&#x271b;',
			'icon-document' : '&#x268c;',
			'icon-document-2' : '&#x2395;',
			'icon-documents' : '&#x274f;',
			'icon-landscape' : '&#x25ad;',
			'icon-fast-forward' : '&#x21a0;',
			'icon-fast-backward' : '&#x219e;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};