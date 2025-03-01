/* global window, document, gtag  */
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