jQuery(function($) {
	// Set all variables to be used in scope
	var frame;

	// ADD IMAGE LINK
	$('.postbox .iworks-field-image .button-upload').on('click', function(event) {
		var $container = $(this).closest('.iworks-field-image');
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if (frame) {
			frame.open();
			return;
		}

		// Create a new media frame
		frame = wp.media({
			title: window.iworks_wordpress_plugin_stub.l10n.wp_media.title,
			button: {
				text: window.iworks_wordpress_plugin_stub.l10n.wp_media.button.text
			},
			multiple: false // Set to true to allow multiple files to be selected
		});

		// When an image is selected in the media frame...
		frame.on('select', function() {
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();
			l(attachment);

			// Send the attachment URL to our custom image input field.
			$('img', $container).attr('src', attachment.url);

			// Send the attachment id to our hidden input
			$('.attachment-id', $container).val(attachment.id);

			// Unhide the remove image link
			$('.button-delete', $container).removeClass('hidden');
		});

		// Finally, open the modal on click
		frame.open();
	});


	// DELETE IMAGE LINK
	$('.postbox .iworks-field-image .button-delete').on('click', function(event) {
		var $container = $(this).closest('.iworks-field-image');
		event.preventDefault();
		// Clear out the preview image
		$('img', $container).attr('src', '');

		// Hide the delete image link
		$(this).addClass('hidden');

		// Delete the image id from the hidden input
		$('.attachment-id', $container).val('');

	});

});
