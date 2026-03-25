/* global window, document */
window.simple_consent_mode = window.simple_consent_mode || [];
window.simple_consent_mode.functions = window.simple_consent_mode.functions || [];
/**
 * Update Clarity based on consent changes
 * 
 * @since 1.4.0
 */
window.simple_consent_mode.functions.clarity_set = function() {
	if (!window.clarity) {
		return;
	}
	window.clarity('consentv2', {
		ad_Storage: window.simple_consent_mode_data.user.ad_storage,
		analytics_Storage: window.simple_consent_mode_data.analytics_storage
	});
};

window.simple_consent_mode.functions.clarity_update = function(consents) {
	if (!window.clarity) {
		return;
	}
	window.clarity('consentv2', {
		ad_Storage: consents.ad_storage,
		analytics_Storage: consents.analytics_storage
	});
};
/**
 * Initialize Clarity when page loads
 */
window.addEventListener('load', function() {
	/**
	 * Wait a bit for consent data to be processed
	 */
	window.setTimeout(function() {
		window.simple_consent_mode.functions.clarity_set();
	}, 100);
});