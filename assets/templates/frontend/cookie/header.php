<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="scm-dialog-header">
	<div class="scm-dialog-header-container">
<?php
if (
	$args['logo']['show']
	&& $args['logo']['src']
) {
	printf(
		'<img src="%s" alt="%s" class="scm-dialog-header-logo">',
		esc_url( $args['logo']['src'] ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}
echo '<p>';
bloginfo( 'name' );
echo '</p>';
?>
	</div>
</div>

