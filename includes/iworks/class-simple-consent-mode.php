<?php
/*

Copyright 2025-PLUGIN_TILL_YEAR Marcin Pietrzak (marcin@iworks.pl)

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

	/**
	 * configuration
	 *
	 * @since 1.0.0
	 */
	private array $configuration = array();

	public function __construct() {
		parent::__construct();
		$this->version = 'PLUGIN_VERSION';
		/**
		 * WordPress Hooks
		 */
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
		add_action( 'wp_head', array( $this, 'action_wp_head_add_defaults' ), 0 );
		add_action( 'wp_footer', array( $this, 'action_wp_footer' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_register_assets' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_enqueue_assets' ) );
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
			'ad_storage'              => 'denied',
			'ad_user_data'            => 'denied',
			'ad_personalization'      => 'denied',
			'analytics_storage'       => 'denied',
			'functionality_storage'   => 'denied',
			'personalization_storage' => 'denied',
			'security_storage'        => 'denied',
		);
		echo $this->eol;
		printf(
			'<script data-name="%s" data-version="%s">',
			esc_attr( __CLASS__ ),
			esc_attr( 'PLUGIN_VERSION' )
		);
		echo $this->eol;
		// Define dataLayer and the gtag function.
		echo 'window.dataLayer = window.dataLayer || [];';
		echo $this->eol;
		echo 'function gtag(){dataLayer.push(arguments);}';
		echo $this->eol;
		echo 'gtag(\'consent\', \'default\',';
		echo $this->eol;
		$flags = 0;
		if ( $this->debug ) {
			$flags = JSON_PRETTY_PRINT;
		}
		echo json_encode( $settings, $flags );
		echo ');';
		echo $this->eol;
		echo '</script>';
		echo $this->eol;
		echo $this->eol;
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

	/**
	 * Add templates to footer.
	 *
	 * @since 1.0.0
	 */
	public function action_wp_footer() {
		$args  = $this->get_configuration();
		$files = array(
			'main',
		);
		foreach ( $files as $file ) {
			$filename = $this->get_template_file_name( 'cookie', $file );
			if ( is_wp_error( $filename ) ) {
				continue;
			}
			$args['id'] = $this->options->get_option_name( $file );
			load_template( $filename, true, $args );
		}
	}

	/**
	 * register assets
	 *
	 * @since 1.0.0
	 */
	public function action_wp_enqueue_scripts_register_assets() {
		$name = $this->options->get_option_name( 'frontend' );
		/**
		 * styles
		 */
		$file = '/assets/styles/simple-consent-mode-frontend' . $this->dev . '.css';
		wp_register_style(
			$name,
			plugins_url( $file, $this->base ),
			array(),
			$this->get_version( $file )
		);
		/**
		 * JS
		 */
		$file = '/assets/scripts/simple-consent-mode-frontend' . $this->dev . '.js';
		wp_register_script(
			$name,
			plugins_url( $file, $this->base ),
			array(),
			$this->get_version( $file )
		);
	}

	/**
	 * configuration for JS, templates
	 *
	 * @since 1.0.0
	 */
	private function get_configuration() {
		if ( empty( $this->configuration ) ) {
			$this->configuration = array(
				'cookie'  => array(
					'name' => $this->options->get_option_name( 'cookie' ),
				),
				'modals'  => array(
					'main' => array(
						'id'          => $this->options->get_option_name( 'main' ),
						'description' => $this->options->get_option( 'm_main_desc' ),
					),
				),
				'nonce'   => wp_create_nonce( 'simple_consent_mode' ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'buttons' => array(),
			);
			/**
			 * buttons
			 */
			$buttons = array(
				'deny',
				'choose',
				'allow',
			);
			foreach ( $buttons as $button ) {
				$this->configuration['buttons'][] = array(
					'data'            => array(
						'cookie' => $button,
					),
					'container_class' => 'scm-modal-button-container',
					'class'           => sprintf( 'scm-modal-button-%s', $button ),
					'value'           => $this->options->get_option( sprintf( 'btn_%s', $button ) ),
				);
			}
		}
		return apply_filters(
			'iworks/simple_consent_mode/configuration',
			$this->configuration
		);
	}

	/**
	 * Enquque styles
	 *
	 * @since 1.3.0
	 */
	public function action_wp_enqueue_scripts_enqueue_assets() {
		$name = $this->options->get_option_name( 'frontend' );
		wp_enqueue_style( $name );
		wp_enqueue_script( $name );
		wp_localize_script( $name, 'simple_consent_mode_data', $this->get_configuration() );
	}

}
