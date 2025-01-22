<?php
/*

Copyright 2018-PLUGIN_TILL_YEAR Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'iworks_simple_consent_mode' ) ) {
	return;
}

require_once( dirname( __FILE__ ) . '/class-simple-consent-mode-base.php' );

class iworks_simple_consent_mode extends iworks_simple_consent_mode_base {

	private $capability;

	public function __construct() {
		parent::__construct();
		$this->version    = 'PLUGIN_VERSION';
		/**
		 * WordPress Hooks
		 */
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
		add_action( 'wp_head', array( $this, 'action_wp_head_add_defaults' ), 0 );
		/**
		 * is active?
		 */
		add_filter( 'simple-consent-mode/is_active', '__return_true' );
	}

	public function action_admin_init() {
		iworks_simple_consent_mode_options_init();
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
	}

	public function action_wp_head_add_defaults() {
		// Set default consent to 'denied' as a placeholder
		// Determine actual values based on your own requirements
		$settings = array(
			'ad_storage'=> 'denied',
			'ad_user_data'=> 'denied',
			'ad_personalization'=> 'denied',
			'analytics_storage'=> 'denied',
			'functionality_storage' => 'denied',
			'personalization_storage' => 'denied',
			'security_storage'=>'denied',
		);
		printf(
			'<script data-name="%s" data-version="%s">',
			esc_attr( __CLASS__ ),
			esc_attr( 'PLUGIN_VERSION' )
		);
		// Define dataLayer and the gtag function.
		echo 'window.dataLayer = window.dataLayer || [];';
		echo 'function gtag(){dataLayer.push(arguments);}';
		echo 'gtag(\'consent\', \'default\',';
		echo json_encode( $settings );
		echo ');';
		echo '</script>';
	}

	/**
	 * Plugin row data
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( $this->dir . '/simple-consent-mode.php' == $file ) {
			if ( ! is_multisite() && current_user_can( $this->capability ) ) {
				$links[] = '<a href="admin.php?page=' . $this->dir . '/admin/index.php">' . __( 'Settings', 'simple-consent-mode' ) . '</a>';
			}
			/* start:free */
			$links[] = '<a href="http://iworks.pl/donate/simple-consent-mode.php">' . __( 'Donate', 'simple-consent-mode' ) . '</a>';
			/* end:free */
		}
		return $links;
	}

	/**
	 * i18n
	 *
	 * @since 1.0.0
	 */
	public function action_init_load_plugin_textdomain() {
		load_plugin_textdomain(
			'simple-consent-mode',
			false,
			plugin_basename( $this->dir ) . '/languages'
		);
	}

}
