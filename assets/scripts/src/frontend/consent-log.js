/* global window, navigator, XMLHttpRequest, FormData */
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

