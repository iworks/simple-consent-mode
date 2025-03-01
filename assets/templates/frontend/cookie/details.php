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
$consents = array(
	'fust' => array(
		'check_show' => true,
		'check_on'   => true,
	),
	'anst' => array(),
	'adst' => array(),
	'adpe' => array(),
	'auda' => array(),
	'pest' => array(
		'check_show' => true,
	),
	'sest' => array(
		'check_show' => true,
	),
);
/**
 * check current consents
 */
$cookie_value_consents = array();
foreach ( $args['consents']['user'] as $consent => $status ) {
	if ( 'granted' === $status ) {
		$cookie_value_consents[] = $consent;
	}
}
/**
 * produce
 */
foreach ( $configuration as $one ) {
	if ( ! isset( $one['name'] ) ) {
		continue;
	}
	if ( ! preg_match( '/^(' . implode( '|', array_keys( $consents ) ) . ')_(title|desc)$/', $one['name'], $matches ) ) {
		continue;
	}
	if (
		isset( $consents[ $matches[1] ]['check_show'] )
		&& $consents[ $matches[1] ]['check_show']
		&& ! $options->get_option( $matches[1] . '_show' )
	) {
		continue;
	}
	switch ( $matches[2] ) {
		case 'title':
			/**
			 * default check
			 */
			$default_checked = false;
			$readonly        = '';
			if (
			isset( $consents[ $matches[1] ]['check_on'] )
			&& $consents[ $matches[1] ]['check_on']
			&& $options->get_option( $matches[1] . '_on' )
			) {
				$default_checked = true;
				$readonly        = ' readonly="readonly" disabled="disabled"';
			}
			echo '<dt>';
			echo '<label class="scm-dialog-switch">';
			printf(
				'<input type="checkbox" id="%s" name="%s" value="%s" class="scm-dialog-switch-checkbox" %s %s>',
				esc_attr( $one['name'] ),
				esc_attr( $matches[1] ),
				esc_attr( $one['codename'] ),
				checked( ( $default_checked || in_array( $one['codename'], $cookie_value_consents ) ), true, false ),
				$readonly
			);
			$label = esc_html( $options->get_option( $one['name'] ) );
			if ( $default_checked ) {
				$label .= ' ';
				$label .= esc_html__( '(always on)', 'simple-consent-mode' );
			}
			echo wpautop( $label );
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

