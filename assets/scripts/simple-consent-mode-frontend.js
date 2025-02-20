/*! Simple Consent Mode - 1.1.1
 * http://simple-consent-mode.iworks.pl/
 * Copyright (c) 2025; * Licensed GPL-3.0 */
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

window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
window.simple_consent_mode.functions.save_log = function( cookie_value ) {
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
	data_to_send.append('consent_value', cookie_value);
	data_to_send.append('url', window.location.href);
	navigator_keys.forEach( function( element ) {
		data_to_send.append(element, navigator[element] );
	});
	xhttp.open( 'post', window.simple_consent_mode_data.ajaxurl, true );
	xhttp.send( data_to_send );
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

