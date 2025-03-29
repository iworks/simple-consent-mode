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
		 * WordPress Hooks
		 */
		add_action( 'init', array( $this, 'action_init_register_iworks_rate' ), PHP_INT_MAX );
		add_action( 'wp_head', array( $this, 'action_wp_head_add_defaults' ), 0 );
		add_action( 'wp_footer', array( $this, 'action_wp_footer' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_register_assets' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts_add_css_variables' ) );
		add_action( 'wp_ajax_simple_consent_mode_save_log', array( $this, 'action_ajax_save_log' ) );
		add_action( 'wp_ajax_nopriv_simple_consent_mode_save_log', array( $this, 'action_ajax_save_log' ) );
		add_action( 'shutdown', array( $this, 'action_shutdown_maybe_delete_log' ) );
		/**
		 * WordPress Shortcodes
		 */
		add_shortcode( 'scm_link_to_show', array( $this, 'shortcode_link_to_show' ) );
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
		 * iWorks Options Hooks
		 */
		add_filter( 'iworks/option/get/simple-consent-mode.php/index/d_logo', array( $this, 'maybe_get_logo_from_other_settings' ) );
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
		$settings = array();
		foreach ( $this->types_of_consent as $one ) {
			$settings[ $one ] = 'denied';
		}
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
			'icon'   => 'i_show',
			'dialog' => false,
		);
		foreach ( $files as $file => $check_to_show_option_name ) {
			if (
				$check_to_show_option_name
				&& ! $this->options->get_option( $check_to_show_option_name )
			) {
				continue;
			}
			$filename = $this->get_template_file_name( 'cookie', $file );
			if ( is_wp_error( $filename ) ) {
				continue;
			}
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
			plugins_url( $file, $this->plugin_file_path ),
			array(),
			$this->get_version( $file )
		);
		/**
		 * JS
		 */
		$file = '/assets/scripts/simple-consent-mode-frontend' . $this->dev . '.js';
		wp_register_script(
			$name,
			plugins_url( $file, $this->plugin_file_path ),
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
			'current_tab' => 'main',
			'consents'    => array(
				'available' => $this->types_of_consent,
				'types'     => $this->get_enabled_types_of_consent(),
				'user'      => $this->check_and_prepare_user_consents( $cookie_value ),
				'forced'    => $this->get_foreced_types_of_consent(),
			),
			'cookie'      => array(
				'expires'  => YEAR_IN_SECONDS,
				'name'     => $cookie_name,
				'path'     => '/',
				'secure'   => is_ssl() ? 'on' : 'off',
				'timezone' => 0,
				'value'    => $cookie_value,
			),
			'logo'        => array(
				'src'  => wp_get_attachment_image_url( $this->options->get_option( 'd_logo' ), 'full' ),
				'show' => $this->options->get_option( 'd_logo_show' ),
			),
			'tabs'        => array(
				'main'    => array(),
				'details' => array(),
				'about'   => array(),
			),
			'buttons'     => array(),
			'nonce'       => wp_create_nonce( 'simple_consent_mode' ),
			'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			'icon'        => array(
				'id'      => $this->get_id( 'icon' ),
				'classes' => array(
					$this->get_id( 'icon' ),
				),
			),
			'dialog'      => array(
				'id'      => $this->get_id( 'dialog' ),
				'classes' => array(
					$this->get_id( 'dialog' ),
				),
				'link'    => array(
					'classname' => $this->get_link_dialog_open_class(),
				),
			),
		);
		/**
		 * tabs
		 */
		foreach ( $this->configuration['tabs'] as $key => $data ) {
			$this->configuration['tabs'][ $key ] = array(
				'id'           => $this->get_id( $key, 'dialog' ),
				'title'        => $this->options->get_option( sprintf( 'm_%s_title', $key ) ),
				'desc'         => $this->options->get_option( sprintf( 'm_%s_desc', $key ) ),
				'classes'      => array(
					'scm-dialog-content-tab',
					sprintf( '%s-%s', $this->get_id( 'content', 'dialog' ), $key ),
					$this->options->get_option_name( 'dialog' ),
				),
				'menu_classes' => array(
					'scm-dialog-content-tabs-tab',
				),
				'show'         => true,
			);
		}
		/**
		 * check about tab
		 */
		$this->configuration['tabs']['about']['show'] = intval( $this->options->get_option( 'm_about_show' ) );
		/**
		 * hide icon
		 */
		if ( empty( $cookie_value ) ) {
			$this->configuration['icon']['classes'][] = 'hidden';
		}
		/**
		 * buttons
		 */
		$buttons                             = array(
			'allow',
			'selected',
			'choose',
			'deny',
		);
		$this->configuration['buttons_list'] = array_keys( $buttons );
		foreach ( $buttons as $button ) {
			$this->configuration['buttons'][ $button ] = array(
				'id'                => $this->get_id( 'button', 'dialog', $button ),
				'data'              => array(
					'action' => $button,
				),
				'container_classes' => array(
					'scm-dialog-button-container',
				),
				'classes'           => array(
					'scm-dialog-button',
					sprintf( 'scm-dialog-button-%s', $button ),
				),
				'value'             => $this->options->get_option( sprintf( 'btn_%s', $button ) ),
			);
			switch ( $button ) {
				case 'allow':
					$this->configuration['buttons'][ $button ]['tab-index'][] = 1;
					break;
				case 'selected':
				case 'deny':
					$this->configuration['buttons'][ $button ]['container_classes'][] = 'hidden';
					break;
			}
		}
		/**
		 * allow button
		 */
		$this->configuration['buttons']['allow']['data']['text-primary']    = $this->configuration['buttons']['allow']['value'];
		$this->configuration['buttons']['allow']['data']['text-secoundary'] = $this->options->get_option( 'btn_allow_all' );
		/**
		 * filter allow to change plugin frontend configuration
		 *
		 * @since 1.0.0
		 */
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

	public function action_wp_enqueue_scripts_add_css_variables() {
		$css    = ':root {';
		$colors = array(
			'c_bg',
			'c_backdrop',
			'c_primary',
			'c_btn_text',
			'c_btn_bg',
			'c_btn_pri_text',
			'c_btn_pri_bg',
			'c_checkbox',
			'i_primary',
			'i_accent',
		);
		foreach ( $colors as $name ) {
			$value = $this->options->get_option( $name );
			if ( empty( $value ) ) {
				continue;
			}
			$code   = preg_replace( '/^._/', '', $name );
			$code   = preg_replace( '/_/', '-', $code );
			$prefix = '';
			if ( preg_match( '/^i_/', $name ) ) {
				$prefix = '-icon';
			}
			$css .= sprintf( '--scm-color%s-%s:', esc_attr( $prefix ), esc_attr( $code ) );
			$css .= esc_attr( $value );
			$css .= ';';
		}
		$css .= sprintf(
			'--scm-logo-max-height: %dpx;',
			$this->options->get_option( 'd_logo_max_height' )
		);
		$css .= sprintf(
			'--scm-dialog-width: %dpx;',
			$this->options->get_option( 'd_width' )
		);
		$css .= sprintf(
			'--scm-border-radius: %dpx;',
			$this->options->get_option( 'd_border_radius' )
		);
		$css .= sprintf(
			'--scm-button-border-radius: %dpx;',
			$this->options->get_option( 'd_btn_border_radius' )
		);
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
			dbdelta( $sql );
			update_option( $option_name_db_version, $install );
		}
	}

	/**
	 * insert simple cookie mode log element.
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
			'appcodename',
			'appname',
			'appversion',
			'language',
			'oscpu',
			'platform',
			'product',
			'productsub',
			'useragent',
			'vendor',
			'vendorsub',
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
			$data[ $key ] = '';
			$value        = filter_input( INPUT_POST, $key );
			if ( ! empty( $value ) && 'undefined' !== $value ) {
				$data[ $key ] = strip_tags( $value );
			}
			$format[] = '%s';
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
				date( 'y-m-d 00:00:00', strtotime( sprintf( '-%d months', $months ) ) ),
			)
		);
	}

	/**
	 * Try to use logo from settings or another plugin.
	 *
	 * Only when empty!
	 *
	 * @since 1.2.0
	 */
	public function maybe_get_logo_from_other_settings( $logo_id ) {
		if ( ! empty( $logo_id ) ) {
			return $logo_id;
		}
		$site_icon_id = intval( get_option( 'site_icon' ) );
		if ( ! empty( $site_icon_id ) ) {
			return $site_icon_id;
		}

			return $logo_id;
	}

	/**
	 * build id or name
	 *
	 * @since 1.2.0
	 */
	private function get_id( $name, $prefix = '', $sufix = '' ) {
		$value = 'scm';
		if ( $prefix ) {
			$value .= '-';
			$value .= $prefix;
		}
		$value .= '-';
		$value .= $name;
		if ( $sufix ) {
			$value .= '-';
			$value .= $sufix;
		}
		return esc_attr( $value );
	}

	/**
	 * get curent allowed types
	 *
	 * @since 1.2.0
	 */
	private function get_enabled_types_of_consent() {
		$enabled_types_of_consent = array(
			'ad_personalization',
			'ad_storage',
			'ad_user_data',
			'analytics_storage',
		);
		if ( $this->options->get_option( 'fust_show' ) ) {
			$enabled_types_of_consent[] = 'functionality_storage';
		}
		if ( $this->options->get_option( 'pest_show' ) ) {
			$enabled_types_of_consent[] = 'personalization_storage';
		}
		if ( $this->options->get_option( 'sest_show' ) ) {
			$enabled_types_of_consent[] = 'security_storage';
		}
		return $enabled_types_of_consent;
	}

	/**
	 * get forced allowed types
	 *
	 * @since 1.2.0
	 */
	private function get_foreced_types_of_consent() {
		$forced_types_of_consent = array();
		if (
			$this->options->get_option( 'fust_show' )
			&& $this->options->get_option( 'fust_on' )
		) {
			$forced_types_of_consent[] = 'functionality_storage';
		}
		return $forced_types_of_consent;
	}

	/**
	 * shortcode
	 *
	 * @since 1.3.0
	 */
	public function shortcode_link_to_show( $args, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'container_tag'     => '',
				'container_classes' => '',
				'classes'           => '',
				'text'              => esc_html__( 'Show Consents', 'simple-consent-mode' ),
				'aria-label'        => esc_html__( 'Open dialog to view and manage consents.', 'simple-consent-mode' ),
			),
			$args,
			'simple-consent-mode-link-to-show'
		);
		if ( $atts['container_tag'] ) {
			$content .= sprintf(
				'<%s class="%s">',
				esc_attr( $args['container_tag'] ),
				esc_attr( $args['container_classes'] )
			);
		}
		$content .= sprintf(
			'<a href="#" class="%s %s" aria-label="%s">%s</a>',
			esc_attr( $this->get_link_dialog_open_class() ),
			esc_attr( $atts['classes'] ),
			esc_attr( $atts['aria-label'] ),
			esc_html( $atts['text'] )
		);
		if ( $atts['container_tag'] ) {
			$content .= sprintf(
				'</%s>',
				esc_attr( $args['container_tag'] )
			);
		}
		return $content;
	}

	private function get_link_dialog_open_class() {
		$this->check_option_object();
		return apply_filters(
			'iworks/simple-consent-mode/link/dialog-open/class-name',
			preg_replace( '/_/', '-', $this->options->get_option_name( 'dialog-open' ) )
		);
	}
}
