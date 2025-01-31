<?php

$options       = get_iworks_simple_consent_mode_options();
$configuration = iworks_simple_consent_mode_options();
$configuration = $configuration['index']['options'];
?><div
	id="<?php echo esc_attr( $args['modals']['choose']['id'] ); ?>"
	class="<?php echo esc_attr( implode( ' ', $args['modals']['choose']['classes'] ) ); ?>"
>
<dl>
<?php
$consents = array(
	'anst',
	'adst',
	'adpe',
	'auda',
);
foreach ( $configuration as $one ) {
	if ( ! isset( $one['name'] ) ) {
		continue;
	}
	if ( ! preg_match( '/^(anst|adst|adpe|auda)_(title|desc)$/', $one['name'], $matches ) ) {
		continue;
	}
	switch ( $matches[2] ) {
		case 'title':
			printf(
				'<dt>%s</dt>',
				esc_attr( $options->get_option( $one['name'] ) )
			);
			break;
		case 'desc':
			printf(
				'<dd>%s</dd>',
				esc_attr( $options->get_option( $one['name'] ) )
			);
			break;

	}
}

?>
</dl>
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

