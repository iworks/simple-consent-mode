/*! Simple Consent Mode - v0.0.1
 * http://simple-consent-mode.iworks.pl/
 * Copyright (c) 2025; * Licensed GPL-3.0 */
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * load
 */
window.addEventListener('load', function(event) {
	var buttons;
	var modal = document.getElementById('scm-modals');
	if ( modal && 1 > modal.length ) {
		return;
	}
	/**
	 * allow choosen
	 */
	window.simple_consent_mode.functions.choosen = function() {
	};
/**
 * set consents
 */
	switch( window.simple_consent_mode.functions.get_cookie_value() ) {
		case 'allow':
			gtag('consent', 'update', {
				ad_storage: 'granted',
				ad_personalization: 'granted',
				ad_user_data: 'granted',
				analytics_storage: 'granted'
			});
			break;
		default:
			var cookie_value = window.simple_consent_mode.functions.get_cookie_value();
			window.console.log('cookie: ', cookie_value, typeof(cookie_value), cookie_value.length);
			break;
	}
	/**
	 * buttons
	 */
	buttons = document.getElementsByClassName('scm-modal-button');
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', function(event) {
			var show = {
				main: false,
				icon: false,
				choose: false,
			};
			event.preventDefault();
			switch( this.dataset.action) {
				case 'allow':
					window.simple_consent_mode.functions.set_cookie(this.dataset.action);
					show.icon = true;
					break;
				case 'choose':
					show.choose = true;
					break;
				case 'show':
					show.main = true;
					break;
				default:
					window.console.log(this.dataset);
			}
			window.console.log(show);
			if ( show.main ) {
				document.getElementById(window.simple_consent_mode_data.modals.main.id).classList.remove('hidden' );
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.main.id).classList.add('hidden' );
			}
			if ( show.icon ) {
				document.getElementById(window.simple_consent_mode_data.modals.icon.id).classList.remove('hidden' );
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.icon.id).classList.add('hidden' );
			}
			if ( show.choose ) {
				document.getElementById(window.simple_consent_mode_data.modals.choose.id).classList.remove('hidden' );
			} else {
				document.getElementById(window.simple_consent_mode_data.modals.choose.id).classList.add('hidden' );
			}
		});
	}


});

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

