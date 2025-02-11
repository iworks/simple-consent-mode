<?php
defined( 'ABSPATH' ) || exit;
$options       = iworks_simple_consent_mode_get_options();
$configuration = iworks_simple_consent_mode_options();
$configuration = $configuration['index']['options'];
$cookie_value  = isset( $args['cookie'] ) && isset( $args['cookie']['value'] ) ? $args['cookie']['value'] : '';
?><div
	id="<?php echo esc_attr( $args['modals']['choose']['id'] ); ?>"
	class="<?php echo esc_attr( implode( ' ', $args['modals']['choose']['classes'] ) ); ?>"
>
<dl>
<?php
$consents              = array(
	'anst',
	'adst',
	'adpe',
	'auda',
);
$cookie_value_consents = array();
if ( preg_match( '/^choose:(.+)$/', $cookie_value, $matches ) ) {
	$cookie_value_consents = preg_split( '/,/', $matches[1] );
}
foreach ( $configuration as $one ) {
	if ( ! isset( $one['name'] ) ) {
		continue;
	}
	if ( ! preg_match( '/^(anst|adst|adpe|auda)_(title|desc)$/', $one['name'], $matches ) ) {
		continue;
	}
	switch ( $matches[2] ) {
		case 'title':
			echo '<dt>';
			echo '<label class="scm-modal-switch">';
			printf(
				'<input type="checkbox" id="%s" name="%s" value="%s" class="scm-modal-switch-checkbox" %s>',
				esc_attr( $one['name'] ),
				esc_attr( $matches[1] ),
				esc_attr( $one['codename'] ),
				checked( in_array( $one['codename'], $cookie_value_consents ), true, false )
			);
			echo wp_kses_post( wpautop( esc_html( $options->get_option( $one['name'] ) ) ) );
			echo '</dt>';
			break;
		case 'desc':
			echo '<dd>';
			echo wpautop( esc_html( $options->get_option( $one['name'] ) ) );
			echo '</dd>';
			break;
	}
}
?>
</dl>
		<ul class="scm-modal-buttons">
<?php
foreach ( $args['modals']['choose']['buttons'] as $button ) {
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
		/* $data is already escaped above */
		$data,
		esc_html( $button['value'] )
	);
	echo '</li>';
}
?>
		</ul>
	</footer>
</div>

