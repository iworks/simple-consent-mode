/*! Simple Consent Mode - 1.2.0
 * http://simple-consent-mode.iworks.pl/
 * Copyright (c) 2025;
 * Licensed GPL-3.0 */
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * load
 */
window.addEventListener('load', function(event) {
	var buttons, checkboxes, i;
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
});

window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
window.simple_consent_mode.functions.save_log = function(cookie_value) {
	var consent_value = '';
	/**
	 * navigator.data
	 */
	var navigator_keys = [
		'appCodeName',
		'appName',
		'appVersion',
		'language',
		'oscpu',
		'platform',
		'product',
		'productSub',
		'userAgent',
		'vendor',
		'vendorSub',
	];
	/**
	 * XMLHttpRequest object
	 */
	var xhttp = new XMLHttpRequest();
	/**
	 * defadata
	 */
	var data_to_send = new FormData();
	data_to_send.append('action', 'simple_consent_mode_save_log');
	data_to_send.append('_wpnonce', window.simple_consent_mode_data.nonce);
	Object.keys(cookie_value).forEach(function(element, item, values) {
		if (consent_value) {
			consent_value += ',';
		}
		consent_value += element;
		consent_value += ':';
		consent_value += cookie_value[element];
	});
	data_to_send.append('consent_value', consent_value);
	data_to_send.append('url', window.location.href);
	navigator_keys.forEach(function(element) {
		data_to_send.append(element, navigator[element]);
	});
	xhttp.open('post', window.simple_consent_mode_data.ajaxurl, true);
	xhttp.send(data_to_send);
};
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 *
 * get cookie value
 */
window.simple_consent_mode.functions.get_cookie_value = function( ) {
	var cname = window.simple_consent_mode_data.cookie.name;
	var name = cname + "=";
	var decoded_cookie = decodeURIComponent(document.cookie);
	var ca = decoded_cookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) === 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
};
/**
 * set Cookie Notice
 */
window.simple_consent_mode.functions.set_cookie = function ( cookie_value ) {
	var expires = new Date();
	var value = parseInt( expires.getTime() );
	var cookie = '';
	/**
	 * set time
	 */
	value = parseInt( expires.getTime() );
	/**
	 * add time
	 */
	value += parseInt( window.simple_consent_mode_data.cookie.expires ) * 1000;
	/**
	 * add time zone
	 */
	value += parseInt( window.simple_consent_mode_data.cookie.timezone ) * 1000;
	/**
	 * set time
	 */
	expires.setTime( value + 2 * 24 * 60 * 60 * 1000 );
	/**
	 * add cookie timestamp
	 */
	cookie = window.simple_consent_mode_data.cookie.name + '=' + cookie_value + ';';
	cookie += ' expires=' + expires.toUTCString() + ';';
	if ( window.simple_consent_mode_data.cookie.domain ) {
		cookie += ' domain=' + window.simple_consent_mode_data.cookie.domain + ';';
	}
	/**
	 * Add cookie now (fix cache issue)
	 */
	cookie += ' path=' + window.simple_consent_mode_data.cookie.path + ';';
	if ( 'on' === window.simple_consent_mode_data.cookie.secure ) {
		cookie += ' secure;';
	}
	window.console.log(cookie);
	document.cookie = cookie;
};


window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * load
 */
window.addEventListener('load', function(event) {
	var tabs = document.getElementsByClassName('scm-dialog-content-tabs-tab');
	if (!tabs || 1 > tabs.length) {
		return;
	}
	/**
	 * show hide buttons choose deny
	 */
	window.simple_consent_mode.functions.show_hide_buttons = function() {
		switch (window.simple_consent_mode_data.current_tab) {
			case 'details':
				var checkboxes = document.getElementsByClassName('scm-dialog-switch-checkbox');
				var is_checked = false;
				document.getElementById('scm-dialog-button-choose').parentNode.classList.add('hidden');
				/**
				 * count selected checkbeoxes
				 */
				if (checkboxes && checkboxes.length) {
					for (var i = 0; i < checkboxes.length; i++) {
						if (checkboxes[i].checked && !checkboxes[i].disabled) {
							is_checked = true;
						}
					}
				}
				if (is_checked) {
					document.getElementById('scm-dialog-button-selected').parentNode.classList.remove('hidden');
					document.getElementById('scm-dialog-button-deny').parentNode.classList.add('hidden');
				} else {
					document.getElementById('scm-dialog-button-selected').parentNode.classList.add('hidden');
					document.getElementById('scm-dialog-button-deny').parentNode.classList.remove('hidden');
				}
				break;
			default:
				document.getElementById('scm-dialog-button-deny').parentNode.classList.add('hidden');
				document.getElementById('scm-dialog-button-selected').parentNode.classList.add('hidden');
				document.getElementById('scm-dialog-button-choose').parentNode.classList.remove('hidden');
				break;
		}
		/**
		 * change text
		 */
		switch (window.simple_consent_mode_data.current_tab) {
			case 'main':
				document.getElementById('scm-dialog-button-allow').innerHTML = document.getElementById('scm-dialog-button-allow').dataset.textPrimary;
				break;
			default:
				document.getElementById('scm-dialog-button-allow').innerHTML = document.getElementById('scm-dialog-button-allow').dataset.textSecoundary;
				break;
		}
	};
	/**
	 * switch to tab
	 */
	window.simple_consent_mode.functions.switch_to_tab = function(tab) {
		var tabs = document.getElementsByClassName('scm-dialog-content-tabs-tab');
		var buttons = window.simple_consent_mode_data.buttons_list;
		/**
		 * change aria (visibility)
		 */
		for (var i = 0; i < tabs.length; i++) {
			document.getElementById(tabs[i].getAttribute('aria-controls')).setAttribute('aria-expanded', 'false');
			tabs[i].ariaSelected = 'false';
		}
		/**
		 * change visibility of buttons
		 */
		window.simple_consent_mode.functions.show_hide_buttons();
	};
	/**
	 * focus button allow on dialog
	 */
	document.getElementById('scm-dialog-button-allow').focus();
	/**
	 * bind choose button action
	 */
	document.getElementById('scm-dialog-button-choose').addEventListener('click', function(event) {
		event.preventDefault();
		document.getElementById(
			window.simple_consent_mode_data.tabs.details.id + '-tabs-tab'
		).click();
	});
	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener('click', function(event) {
			var height = 0;
			var tab = this.getAttribute('aria-controls');
			var tabs_inside = document.getElementsByClassName('scm-dialog-content-tab');
			event.preventDefault();
			if ('true' === this.ariaSelected) {
				return;
			}
			/**
			 * current tab
			 */
			window.simple_consent_mode_data.current_tab = this.dataset.tab;
			/**
			 * switch tab
			 */
			window.simple_consent_mode.functions.switch_to_tab(tab);
			this.ariaSelected = 'true';
			document.getElementById(tab).setAttribute('aria-expanded', 'true');
			height += document.getElementById('scm-dialog').offsetHeight;
			height -= document.getElementsByClassName('scm-dialog-header')[0].offsetHeight;
			height -= document.getElementsByClassName('scm-dialog-content-tabs')[0].offsetHeight;
			height -= document.getElementsByClassName('scm-dialog-buttons')[0].offsetHeight;
			for (var j = 0; j < tabs_inside.length; j++) {
				tabs_inside[j].style.maxHeight = height + 'px';
			}
		});
	}
});