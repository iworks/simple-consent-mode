<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function iworks_simple_consent_mode_options() {
	$options = array();
	//$parent = SET SOME PAGE;
	/**
	 * main settings
	 */
	$options['index'] = array(
		'version'    => '0.0',
		'page_title' => __( 'Configuration', 'simple-consent-mode' ),
		'menu'       => 'options',
		// 'parent' => $parent,
		'options'    => array(),
		'metaboxes'  => array(),
		'pages'      => array(),
	);
	return $options;
}

