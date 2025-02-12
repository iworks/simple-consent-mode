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
			echo wp_kses_post( wpautop( esc_html( $options->get_option( $one['name'] ) ) ) );
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
		/* $data is already escaped above in a foreach() */
		$data,
		esc_html( $button['value'] )
	);
	echo '</li>';
}
?>
		</ul>
	</footer>
	<button class="scm-modal-button" data-action="close"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="var(--scm-color-primary)"/></svg><span class="sr-only"><?php esc_html_e( 'Close', 'simple-consent-mode' ); ?></button>
</div>

