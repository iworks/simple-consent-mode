/* global window, document, gtag */
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
