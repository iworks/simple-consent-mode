<?php defined( 'ABSPATH' ) || exit; ?>
<?php $key = preg_replace( '/\.php$/', '', basename( __FILE__ ) ); ?>
<?php
$options       = iworks_simple_consent_mode_get_options();
$configuration = iworks_simple_consent_mode_options();
$configuration = $configuration['index']['options'];
$cookie_value  = isset( $args['cookie'] ) && isset( $args['cookie']['value'] ) ? $args['cookie']['value'] : '';
?>
<div
	id="<?php echo esc_attr( $args['tabs'][ $key ]['id'] ); ?>"
	class="<?php echo esc_attr( implode( ' ', $args['tabs'][ $key ]['classes'] ) ); ?>"
	role="tabpanel"
	aria-labelledby="<?php echo esc_attr( $args['tabs'][ $key ]['id'] ); ?>-tab"
	aria-expanded="false"
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
			echo '<label class="scm-dialog-switch">';
			printf(
				'<input type="checkbox" id="%s" name="%s" value="%s" class="scm-dialog-switch-checkbox" %s>',
				esc_attr( $one['name'] ),
				esc_attr( $matches[1] ),
				esc_attr( $one['codename'] ),
				checked( in_array( $one['codename'], $cookie_value_consents ), true, false )
			);
			echo wpautop( esc_html( $options->get_option( $one['name'] ) ) );
			echo '</dt>';
			break;
		case 'desc':
			echo '<dd>';
			echo wp_kses_post( wpautop( $options->get_option( $one['name'] ) ) );
			echo '</dd>';
			break;
	}
}
?>
</dl>
</div>

