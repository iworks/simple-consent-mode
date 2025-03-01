<?php defined( 'ABSPATH' ) || exit; ?>
<?php $key = preg_replace( '/\.php$/', '', basename( __FILE__ ) ); ?>
<div
	id="<?php echo esc_attr( $args['tabs'][ $key ]['id'] ); ?>"
	class="<?php echo esc_attr( implode( ' ', $args['tabs'][ $key ]['classes'] ) ); ?>"
	role="tabpanel"
	aria-labelledby="<?php echo esc_attr( $args['tabs'][ $key ]['id'] ); ?>-tab"
	aria-expanded="false"
>
<?php echo wp_kses_post( wpautop( $args['tabs'][ $key ]['desc'] ) ); ?>
</div>
