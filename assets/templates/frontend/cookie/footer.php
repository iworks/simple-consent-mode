<footer class="scm-dialog-buttons">
	<ul class="scm-dialog-buttons-wrapper">
<?php
foreach ( $args['buttons'] as $button_key => $button ) {
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
	printf( '<li class="%s">', esc_attr( implode( ' ', $button['container_classes'] ) ) );
	printf(
		'<button id="scm-dialog-button-%s" class="%s"%s%s>%s</button>',
		esc_attr( $button_key ),
		esc_attr( implode( ' ', $button['classes'] ) ),
		/* $data is already escaped above in a foreach()*/
		$data,
		isset( $button['tab-index'] ) ? sprintf( ' tab-index="%d"', $button['tab-index'] ) : '',
		esc_html( $button['value'] )
	);
	echo '</li>';
}
?>
	</ul>
</footer>
