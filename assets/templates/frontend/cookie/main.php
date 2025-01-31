<div id="<?php echo esc_attr( $args['modals']['main']['id'] ); ?>" class="<?php echo esc_attr( implode( ' ', $args['modals']['main']['classes'] ) ); ?>">
<?php if ( isset( $args['modals']['main']['description'] ) && $args['modals']['main']['description'] ) { ?>
	<div class="scm-modal-description"><?php echo wpautop( esc_html( $args['modals']['main']['description'] ) ); ?></div>
<?php } ?>
	<footer class="scm-modal-buttons-wrapper">
		<ul class="scm-modal-buttons">
<?php
foreach ( $args['modals']['main']['buttons'] as $button ) {
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
		'<button class="%s"%s>%s</button>',
		esc_attr( implode( ' ', $button['classes'] ) ),
		$data,
		esc_html( $button['value'] )
	);
	echo '</li>';
}
?>
		</ul>
	</footer>
</div>
