<?php defined( 'ABSPATH' ) || exit; ?>
<dialog id="scm-dialog" class="scm-dialog">
<?php include_once __DIR__ . '/header.php'; ?>
<div class="scm-dialog-content" role="tablist">
	<div class="scm-dialog-contents">
<?php include_once __DIR__ . '/main.php'; ?>
<?php include_once __DIR__ . '/details.php'; ?>
<?php include_once __DIR__ . '/about.php'; ?>
	</div>
	<ul class="scm-dialog-content-tabs">
<?php
foreach ( $args['tabs'] as $key => $data ) {
	echo '<li>';
	printf(
		'<a href="#%1$s" class="%2$s" role="tab" aria-selected="%3$s" aria-controls="%1$s" id="%1$s-tab">%4$s</a>',
		esc_html( $data['id'] ),
		esc_attr( implode( ' ', $data['menu_classes'] ) ),
		esc_attr( in_array( 'current', $data['menu_classes'] ) ? 'true' : 'false' ),
		esc_html( $data['title'] )
	);
	echo '</li>';
}
?>
	</ul>
</div>
<?php include_once __DIR__ . '/footer.php'; ?>
</dialog>
