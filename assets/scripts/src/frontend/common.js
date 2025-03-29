/* global window, document, gtag  */
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * load
 */
window.addEventListener('load', function(event) {
	var buttons, checkboxes, i, links;
	var dialog = document.getElementById('scm-dialog');
	if (!dialog || 1 > dialog.length) {
		return;
	}
	/**
	 * set consents
	 */
	if (Object.keys(window.simple_consent_mode_data.consents.user).length) {
		gtag('consent', 'update', window.simple_consent_mode_data.consents.user);
	} else {
		dialog.showModal();
	}
	/**
	 * checkbox
	 */
	checkboxes = document.getElementsByClassName('scm-dialog-switch-checkbox');
	for (i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('click', function(event) {
			window.simple_consent_mode.functions.show_hide_buttons();
		});
	}
	/**
	 * buttons
	 */
	buttons = document.getElementsByClassName('scm-dialog-button');
	for (i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', function(event) {
			var consents = {};
			var enabled_types_of_consents = window.simple_consent_mode_data.consents.types;
			var forced_types_of_consents = window.simple_consent_mode_data.consents.forced;
			var i;
			event.preventDefault();
			switch (this.dataset.action) {
				case 'choose':
					return;
				case 'show':
					/**
					 * open dialog & hide icon
					 */
					document.getElementById('scm-dialog').showModal();
					document.getElementById('scm-icon').classList.add('hidden');
					return;
				case 'allow':
					for (i = 0; i < enabled_types_of_consents.length; i++) {
						consents[enabled_types_of_consents[i]] = 'granted';
					}
					break;
				case 'deny':
					for (i = 0; i < enabled_types_of_consents.length; i++) {
						if (-1 === forced_types_of_consents.indexOf(enabled_types_of_consents[i])) {
							consents[enabled_types_of_consents[i]] = 'denied';
						} else {
							consents[enabled_types_of_consents[i]] = 'granted';
						}
					}
					break;
				default:
					var checkboxes = document.getElementsByClassName('scm-dialog-switch-checkbox');
					for (i = 0; i < enabled_types_of_consents.length; i++) {
						consents[enabled_types_of_consents[i]] = 'denied';
					}
					for (i = 0; i < checkboxes.length; i++) {
						if (checkboxes[i].checked) {
							consents[checkboxes[i].value] = 'granted';
						}
					}
			}
			/**
			 * update status
			 */
			gtag('consent', 'update', consents );
			window.simple_consent_mode.functions.set_cookie(JSON.stringify(consents));
			window.simple_consent_mode.functions.save_log(consents);
			/**
			 * close dialog & show icon
			 */
			document.getElementById('scm-dialog').close();
			document.getElementById('scm-icon').classList.remove('hidden');
		});
	}
	/**
	 * links: .iworks-simple-consent-mode-base-dialog-open
	 */
	links = document.getElementsByClassName( window.simple_consent_mode_data.dialog.link.classname );
	for (i = 0; i < links.length; i++) {
		links[i].addEventListener('click', function(event) {
			event.preventDefault();
			document.getElementById('scm-dialog').showModal();
		});
	}

});
