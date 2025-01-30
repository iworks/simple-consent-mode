/*! Simple Consent Mode - v0.0.1
 * http://simple-consent-mode.iworks.pl/
 * Copyright (c) 2025; * Licensed GPL-3.0 */
window.addEventListener( 'load', function (event) {
	var modal;
	var value = window.simple_consent_mode.functions.get_cookie_value();
window.console.log('cookie: ', value, typeof( value ), value.length );
	/**
	 * show
	 */
	if ( 0 === value.length ) {
		modal = document.getElementById( window.simple_consent_mode_data.modals.main.id);
		modal.style.display = 'block';
	}


	if ( 0 ) {
		var button_close = document.getElementById( window.simple_consent_mode.buttons.close.element_id );
		if ( 10 ) {
			button_close.addEventListener( 'click', function (event) {
				event.preventDefault();
				window.simple_consent_mode.functions.set_cookie_notice();
				return false;
			});
		}
		/**
		 * it ws already shown
		 */
		value = window.simple_consent_mode.functions.get_cookie_value( window.simple_consent_mode.cookie.name + '_close' );
		if ( 'hide' === value ) {
			document.getElementById( window.simple_consent_mode.name ).remove();
		}
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
window.simple_consent_mode.functions.set_cookie_notice = function () {
	var notice = document.getElementById( window.simple_consent_mode.name );
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
	value += parseInt( window.simple_consent_mode.cookie.value ) * 1000;
	/**
	 * add time zone
	 */
	value += parseInt( window.simple_consent_mode.cookie.timezone ) * 1000;
	/**
	 * set time
	 */
	expires.setTime( value + 2 * 24 * 60 * 60 * 1000 );
	/**
	 * add cookie timestamp
	 */
	cookie = window.simple_consent_mode.cookie.name + '=' + value/1000 + ';';
	cookie += ' expires=' + expires.toUTCString() + ';';
	if ( window.simple_consent_mode.cookie.domain ) {
		cookie += ' domain=' + window.simple_consent_mode.cookie.domain + ';';
	}
	/**
	 * Add cookie now (fix cache issue)
	 */
	cookie += ' path=' + window.simple_consent_mode.cookie.path + ';';
	if ( 'on' === window.simple_consent_mode.cookie.secure ) {
		cookie += ' secure;';
	}
	document.cookie = cookie;
	cookie = window.simple_consent_mode.cookie.name + '_close=hide;';
	cookie += ' expires=;';
	if ( window.simple_consent_mode.cookie.domain ) {
		cookie += ' domain=' + window.simple_consent_mode.cookie.domain + ';';
	}
	cookie += ' path=' + window.simple_consent_mode.cookie.path + ';';
	if ( 'on' === window.simple_consent_mode.cookie.secure ) {
		cookie += ' secure;';
	}
	document.cookie = cookie;
	/**
	 * remove
	 */
	notice.remove();
};

