/*! Simple Consent Mode - 1.3.1
 * https://github.com/iworks/simple-consent-mode/
 * Copyright (c) 2025;
 * Licensed GPL-3.0 */
jQuery(document).ready(function($) {
	$('input[name=iw_scm_log_export]').on( 'click', function(e) {
		var $form = $('<form method="post"></form>');
		e.preventDefault();
		$form.append('<input type="hidden" name="_wpnonce" value="'+$(this).data('nonce') +'">');
		$form.append('<input type="hidden" name="export" value="export">');
		$('body').append($form);
		$form.submit();
	});
});
