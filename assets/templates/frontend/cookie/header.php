<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="scm-dialog-header">
<?php
if ( $args['logo'] ) {
	printf(
		'<img src="%s" alt="%s" class="scm-dialog-header-logo">',
		esc_url( $args['logo'] ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}
?>
</div>

