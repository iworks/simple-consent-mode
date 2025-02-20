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

	/**
	 * configuration
	 *
	 * @since 1.0.0
	 */
	private array $configuration = array();

	public function __construct() {
		parent::__construct();
		/**
		 * add database table name
		 */
		/**
		 * WordPress Hooks
		 */
		add_action( 'init', array( $this, 'action_init_register_iworks_rate' ), PHP_INT_MAX );
		add_action( 'wp_head', array( $this, 'action_wp_head_add_defaults' ), 0 );
		add_action( 'wp_footer', array( $this, 'action_wp_footer' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_register_assets' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_add_colors' ) );
		add_action( 'wp_ajax_simple_consent_mode_save_log', array( $this, 'action_ajax_save_log' ) );
		add_action( 'wp_ajax_nopriv_simple_consent_mode_save_log', array( $this, 'action_ajax_save_log' ) );
		add_action( 'shutdown', array( $this, 'action_shutdown_maybe_delete_log' ) );
		/**
		 * db install
		 *
		 * @since 1.1.0
		 */
		add_action( 'admin_init', array( $this, 'db_install' ) );
		/**
		 * is active?
		 */
		add_filter( 'simple-consent-mode/is_active', '__return_true' );
		/**
		 * iWorks Rate Class
		 */
		add_filter( 'iworks_rate_notice_logo_style', array( $this, 'filter_plugin_logo' ), 10, 2 );
		/**
		 * load github class
		 */
		$filename = __DIR__ . '/simple-consent-mode/class-simple-consent-mode-github.php';
		if ( is_file( $filename ) ) {
			include_once $filename;
			new iworks_simple_consent_mode_github();
		}
		/**
		 * admin
		 */
		if ( is_admin() ) {
			$filename = __DIR__ . '/simple-consent-mode/class-simple-consent-mode-wp-admin.php';
			if ( is_file( $filename ) ) {
				include_once $filename;
				new iworks_simple_consent_mode_wp_admin();
			}
		}
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
		echo esc_html( $this->eol );
		printf(
			'<script data-name="%s" data-version="%s">',
			esc_attr( __CLASS__ ),
			esc_attr( 'PLUGIN_VERSION' )
		);
		echo esc_html( $this->eol );
		// Define dataLayer and the gtag function.
		echo 'window.dataLayer = window.dataLayer || [];';
		echo esc_html( $this->eol );
		echo 'function gtag(){dataLayer.push(arguments);}';
		echo esc_html( $this->eol );
		echo 'gtag(\'consent\', \'default\',';
		echo esc_html( $this->eol );
		$flags = 0;
		if ( $this->debug ) {
			$flags = JSON_PRETTY_PRINT;
		}
		echo wp_json_encode( $settings, $flags );
		echo ');';
		echo esc_html( $this->eol );
		echo '</script>';
		echo esc_html( $this->eol );
		echo esc_html( $this->eol );
	}


	/**
	 * Add templates to footer.
	 *
	 * @since 1.0.0
	 */
	public function action_wp_footer() {
		$args  = $this->get_configuration();
		$files = array(
			'choose',
			'icon',
			'main',
		);
		echo '<div class="scm-modals-container">';
		foreach ( $files as $file ) {
			$filename = $this->get_template_file_name( 'cookie', $file );
			if ( is_wp_error( $filename ) ) {
				continue;
			}
			$args['id'] = $this->options->get_option_name( $file );
			load_template( $filename, true, $args );
		}
		echo '</div>';
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
			$this->get_version( $file ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	/**
	 * get cookie name
	 *
	 * @since 1.0.0
	 */
	private function get_cookie_name() {
		return sprintf(
			'scm%s',
			crc32(
				sprintf(
					'%s_%d',
					$this->options->get_option_name( 'cookie' ),
					$this->options->get_option( 'cookie_version' )
				)
			)
		);
	}

	/**
	 * configuration for JS, templates
	 *
	 * @since 1.0.0
	 */
	private function get_configuration() {
		if ( ! empty( $this->configuration ) ) {
			return apply_filters(
				'iworks/simple_consent_mode/configuration',
				$this->configuration
			);
		}
		$cookie_name         = $this->get_cookie_name();
		$cookie_value        = sanitize_text_field(
			isset( $_COOKIE[ $cookie_name ] ) ? wp_unslash( $_COOKIE[ $cookie_name ] ) : null
		);
		$this->configuration = array(
			'consents' => $this->set_consents( $cookie_value ),
			'cookie'   => array(
				'expires'  => YEAR_IN_SECONDS,
				'name'     => $cookie_name,
				'path'     => '/',
				'secure'   => is_ssl() ? 'on' : 'off',
				'timezone' => 0,
				'value'    => $cookie_value,
			),
			'modals'   => array(
				'choose' => array(
					'buttons' => array(
						array(
							'data'            => array(
								'action' => 'close',
							),
							'container_class' => 'scm-modal-button-container',
							'classes'         => array(
								'scm-modal-button',
								'scm-modal-button-close',
							),
							'value'           => $this->options->get_option( 'btn_close' ),
						),
					),
				),
				'icon'   => array(),
				'main'   => array(
					'description' => $this->options->get_option( 'm_main_desc' ),
					'buttons'     => array(),
				),
			),
			'nonce'    => wp_create_nonce( 'simple_consent_mode' ),
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
		);
		foreach ( $this->configuration['modals'] as $key => $data ) {
			$this->configuration['modals'][ $key ]['id']      = $this->options->get_option_name( $key );
			$this->configuration['modals'][ $key ]['classes'] = array(
				'scm-modal',
				sprintf( 'scm-modal-%s', $key ),
				$this->options->get_option_name( 'modal' ),
			);
		}
		/**
		 * hide
		 */
		$this->configuration['modals']['choose']['classes'][] = 'hidden';
		if ( empty( $cookie_value ) ) {
			$this->configuration['modals']['icon']['classes'][] = 'hidden';
		} else {
			$this->configuration['modals']['main']['classes'][] = 'hidden';
		}
		/**
		 * buttons
		 */
		$buttons = array(
			'allow',
			'choose',
			'deny',
		);
		foreach ( $buttons as $button ) {
			$this->configuration['modals']['main']['buttons'][] = array(
				'data'            => array(
					'action' => $button,
				),
				'container_class' => 'scm-modal-button-container',
				'classes'         => array(
					'scm-modal-button',
					sprintf( 'scm-modal-button-%s', $button ),
				),
				'value'           => $this->options->get_option( sprintf( 'btn_%s', $button ) ),
			);
		}
		return apply_filters(
			'iworks/simple_consent_mode/configuration',
			$this->configuration
		);
	}

	private function set_consents( $value ) {
		switch ( $value ) {
			case 'deny':
			case null:
				return array();
			case 'allow':
				return array(
					'ad_storage'         => 'granted',
					'ad_personalization' => 'granted',
					'ad_user_data'       => 'granted',
					'analytics_storage'  => 'granted',
				);
				break;
		}
		/**
		 * choosen
		 */
		$consents = array();
		if ( preg_match( '/^choose:(.+)$/', $value, $matches ) ) {
			foreach ( preg_split( '/,/', $matches[1] ) as $one ) {
				$consents[ $one ] = 'granted';
			}
		}
		return $consents;
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

	public function action_wp_enqueue_scripts_add_colors() {
		$css    = ':root {';
		$colors = array(
			'c_primary',
			'c_accent',
			'c_checkbox',
			'i_primary',
			'i_accent',
		);
		foreach ( $colors as $name ) {
			$code   = preg_replace( '/^._/', '', $name );
			$prefix = '';
			if ( preg_match( '/^i_/', $name ) ) {
				$prefix = '-icon';
			}
			$css .= sprintf( '--scm-color%s-%s:', esc_attr( $prefix ), esc_attr( $code ) );
			$css .= esc_attr( $this->options->get_option( $name ) );
			$css .= ';';
		}
		$css .= '}';
		wp_add_inline_style( $this->options->get_option_name( 'frontend' ), $css );
	}

	/**
	 * register plugin to iWorks Rate Helper
	 *
	 * @since 1.0.0
	 */
	public function action_init_register_iworks_rate() {
		if ( ! class_exists( 'iworks_rate' ) ) {
			include_once dirname( __FILE__ ) . '/rate/rate.php';
		}
		do_action(
			'iworks-register-plugin',
			plugin_basename( $this->plugin_file ),
			__( 'Simple Consent Mode', 'simple-consent-mode' ),
			'simple-consent-mode'
		);
	}

	/**
	 * Plugin logo for rate messages
	 *
	 * @since 1.0.0
	 *
	 * @param string $logo Logo, can be empty.
	 * @param object $plugin Plugin basic data.
	 */
	public function filter_plugin_logo( $logo, $plugin ) {
		if ( is_object( $plugin ) ) {
			$plugin = (array) $plugin;
		}
		if ( 'simple-consent-mode' === $plugin['slug'] ) {
			return plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . '/assets/images/logo.svg';
		}
		return $logo;
	}

	/**
	 * register_activation_hook
	 *
	 * @since 1.1.0
	 */
	public function register_activation_hook() {
		$this->db_install();
		$this->check_option_object();
		$this->options->set_option_function_name( 'iworks_simple_consent_mode_options' );
		$this->options->set_option_prefix( IWORKS_SIMPLE_CONSENT_MODE_PREFIX );
		$this->options->activate();
		do_action( 'iworks/simple-consent-mode/register_activation_hook' );
	}

	/**
	 * register_deactivation_hook
	 *
	 * @since 1.1.0
	 */
	public function register_deactivation_hook() {
		$this->check_option_object();
		$this->options->deactivate();
		do_action( 'iworks/simple-consent-mode/register_deactivation_hook' );
	}

	/**
	 * DB Install/update
	 *
	 * @since 1.1.0
	 */
	public function db_install() {
		global $wpdb;
		$option_name_db_version = 'iworks_scm_db_version';
		/**
		 * get Version
		 */
		$version = intval( get_option( $option_name_db_version ) );
		if ( empty( $version ) ) {
			add_option( $option_name_db_version, 0, '', 'no' );
		}
		/**
		 * 20241011
		 */
		$install = 20250218;
		if ( $install > $version ) {
			$charset_collate = $wpdb->get_charset_collate();
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			$table_name = $wpdb->iworks_scm_log;
			$sql        = "CREATE TABLE $table_name (
				consent_id bigint unsigned not null auto_increment,
				consent_date datetime default current_timestamp,
				consent_value text,
				user_id bigint unsigned null default 0,
				ip varchar(39) default null,
				ipx varchar(39) default null,
				appCodeName text,
				appName text,
				appVersion text,
				language text,
				oscpu text,
				platform text,
				product text,
				productSub text,
				userAgent text,
				vendor text,
				vendorSub text,
				url text,
				scm_version varchar(20) not null,
				cookie_version varchar(20) not null,
				cookie_name text,
				primary key ( consent_id ),
				key ( consent_date ),
				key ( user_id )
			) $charset_collate;";
			dbDelta( $sql );
			update_option( $option_name_db_version, $install );
		}
	}

	/**
	 * Insert Simple Cookie Mode Log element.
	 *
	 * @since 1.1.0
	 */
	public function action_ajax_save_log() {
		check_ajax_referer( 'simple_consent_mode' );
		if ( 1 > intval( $this->options->get_option( 'log_status' ) ) ) {
			exit;
		}
		$keys   = array(
			'consent_value',
			'url',
			'appCodeName',
			'appName',
			'appVersion',
			'language',
			'oscpu',
			'platform',
			'product',
			'productSub',
			'userAgent',
			'vendor',
			'vendorSub',
		);
		$data   = array(
			'user_id'        => get_current_user_id(),
			'ip'             => $_SERVER['REMOTE_ADDR'],
			'ipx'            => isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
			'cookie_version' => $this->options->get_option( 'cookie_version' ),
			'cookie_name'    => $this->get_cookie_name(),
		);
		$format = array(
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
		);
		foreach ( $keys as $key ) {
			$data[ $key ] = strip_tags( filter_input( INPUT_POST, $key ) );
			$format[]     = '%s';
		}
		global $wpdb;
		$wpdb->insert(
			$wpdb->iworks_scm_log,
			$data,
			$format
		);
		exit;
	}

	/**
	 * delete old logs
	 *
	 * @since 1.1.0
	 */
	public function action_shutdown_maybe_delete_log() {
		$months = intval( $this->options->get_option( 'log_duration' ) );
		if ( 1 > $months ) {
			return;
		}
		global $wpdb;
		$wpdb->query(
			$wpdb->prepare(
				"delete from {$wpdb->iworks_scm_log} where consent_date < %s",
				date( 'Y-m-d 00:00:00', strtotime( sprintf( '-%d months', $months ) ) ),
			)
		);
	}

}
