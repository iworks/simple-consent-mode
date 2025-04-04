<?php defined( 'ABSPATH' ) || exit; ?>
<?php $key = preg_replace( '/\.php$/', '', basename( __FILE__ ) ); ?>
<dialog
	id="<?php echo esc_attr( $args[ $key ]['id'] ); ?>"
	class="<?php echo esc_attr( implode( ' ', $args[ $key ]['classes'] ) ); ?>"
>
	<div class="scm-dialog-wrapper">
<?php include_once __DIR__ . '/header.php'; ?>
<div class="scm-dialog-content" role="tablist">
	<div class="scm-dialog-contents">
<?php
$count = 0;
foreach ( $args['tabs'] as $key => $data ) {
	if ( $data['show'] ) {
		include_once realpath( __DIR__ . '/' . $key . '.php' );
		$count++;
	}
}
echo '</div>';
printf( '<ul class="scm-dialog-content-tabs scm-dialog-content-tabs-%d">', $count );
$first = true;
foreach ( $args['tabs'] as $key => $data ) {
	if ( $data['show'] ) {
		echo '<li>';
		printf(
			'<a data-tab="%5$s" href="#%1$s" id="%1$s-tabs-tab" class="%2$s" role="tab" aria-selected="%3$s" aria-controls="%1$s" id="%1$s-tab">%4$s</a>',
			esc_html( $data['id'] ),
			esc_attr( implode( ' ', $data['menu_classes'] ) ),
			esc_attr( $first ? 'true' : 'false' ),
			esc_html( $data['title'] ),
			esc_attr( $key )
		);
		echo '</li>';
		$first = false;
	}
}
?>
	</ul>
</div>
<?php include_once __DIR__ . '/footer.php'; ?>
	</div>
</dialog>
