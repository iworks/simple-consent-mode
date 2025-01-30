/* global window, document */
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
