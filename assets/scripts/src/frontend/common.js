/* global window, document, gtag */
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * load
 */
window.addEventListener('load', function(event) {
	var buttons, checkboxes, i;
	var modal = document.getElementById('scm-modals');
	if (modal && 1 > modal.length) {
		return;
	}
	/**
	 * allow choosen
	 */
	window.simple_consent_mode.functions.choosen = function() {};
	/**
	 * set consents
	 */
	if (Object.keys(window.simple_consent_mode_data.consents).length) {
		gtag('consent', 'update', window.simple_consent_mode_data.consents);
	}
	/**
	 * checkbox
	 */
	checkboxes = document.getElementsByClassName('scm-modal-switch-checkbox');
	for (i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('click', function(event) {
			var cookie_value = '';
			var checkboxes_inside = document.getElementsByClassName('scm-modal-switch-checkbox');
			for (var j = 0; j < checkboxes_inside.length; j++) {
				var gtag_value = {};
				gtag_value[checkboxes_inside[j].value] = 'denied';
				if (checkboxes_inside[j].checked) {
					if (cookie_value) {
						cookie_value += ',';
					}
					cookie_value += checkboxes_inside[j].value;
					gtag_value[checkboxes_inside[j].value] = 'granted';
				}
				gtag('consent', 'update', gtag_value);
			}
			if (cookie_value) {
				window.simple_consent_mode.functions.set_cookie('choose:' + cookie_value);
				window.simple_consent_mode.functions.save_log(cookie_value);
			}
		});
	}
	/**
	 * buttons
	 */
	buttons = document.getElementsByClassName('scm-modal-button');
	for (i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', function(event) {
			var show = {
				main: false,
				icon: false,
				choose: false,
			};
			event.preventDefault();
			switch (this.dataset.action) {
				case 'allow':
					window.simple_consent_mode.functions.set_cookie(this.dataset.action);
					window.simple_consent_mode.functions.save_log(this.dataset.action);
					show.icon = true;
					gtag('consent', 'update', {
						ad_storage: 'granted',
						ad_personalization: 'granted',
						ad_user_data: 'granted',
						analytics_storage: 'granted'
					});
					break;
				case 'deny':
					window.simple_consent_mode.functions.set_cookie(this.dataset.action);
					window.simple_consent_mode.functions.save_log(this.dataset.action);
					show.icon = true;
					gtag('consent', 'update', {
						ad_storage: 'denied',
						ad_personalization: 'denied',
						ad_user_data: 'denied',
						analytics_storage: 'denied'
					});
					break;
				case 'close':
					show.icon = true;
					break;
				case 'choose':
					show.choose = true;
					break;
				case 'show':
					show.main = true;
					break;
			}
			if (show.main) {
				document.getElementById(window.simple_consent_mode_data.modals.main.id).classList.remove('hidden');
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.main.id).classList.add('hidden');
			}
			if (show.icon) {
				document.getElementById(window.simple_consent_mode_data.modals.icon.id).classList.remove('hidden');
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.icon.id).classList.add('hidden');
			}
			if (show.choose) {
				document.getElementById(window.simple_consent_mode_data.modals.choose.id).classList.remove('hidden');
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.choose.id).classList.add('hidden');
			}
		});
	}
});
