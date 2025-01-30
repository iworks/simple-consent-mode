<?php
$options    = get_iworks_simple_consent_mode_options();
$modal_name = 'main';
$modal      = $args['modals'][ $modal_name ];
?>
<div class="scm-modal" id="<?php echo esc_attr( $modal['id'] ); ?>" style="display:none" role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="simple-consent-mode-main-description" class="scm-modal">
	<div class="scm-modal-description"><?php echo wpautop( esc_html( $modal['description'] ) ); ?></div>

	<footer class="scm-modal-buttons-wrapper">
		<ul class="scm-modal-buttons">
<?php
foreach ( $args['buttons'] as $button ) {
	$data = '';
	if ( isset( $button['data'] ) ) {
		foreach ( $button['data'] as $data_key => $data_value ) {
			$data .= sprintf(
				' data-%s="%s"',
				esc_attr( $data_key ),
				esc_attr( $data_value )
			);
		}
	}
	printf( '<li class="%s">', esc_attr( $button['container_class'] ) );
	printf(
		'<button class="scm-modal-button scm-modal-button-%s"%s>%s</button>',
		esc_attr( $button['class'] ),
		$data,
		esc_html( $button['value'] )
	);
	echo '</li>';
}
?>
		</ul>
	</footer>
</div>
