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

if ( class_exists( 'iworks_simple_consent_mode_base' ) ) {
	return;
}

class iworks_simple_consent_mode_base {

	protected $dev;
	protected $meta_prefix = '_iw';
	protected $base;
	protected $dir;
	protected $url;
	protected $plugin_file;
	protected $plugin_file_path;

	/**
	 * plugin settings capability
	 */
	private string $capability = 'manage_options';

	/**
	 * plugin version
	 */
	protected string $version = 'PLUGIN_VERSION';

	/**
	 * options
	 */
	protected $options;

	/**
	 * DEBUG
	 *
	 * @since 1.0.0
	 */
	protected $debug = false;

	/**
	 * EOL?
	 *
	 * @since 1.0.0
	 */
	protected string $eol = '';

	/**
	 * types of consent
	 *
	 * @since 1.2.0
	 */
	protected array $types_of_consent = array(
		'ad_personalization',
		'ad_storage',
		'ad_user_data',
		'analytics_storage',
		'functionality_storage',
		'personalization_storage',
		'security_storage',
	);

	public function __construct() {
		/**
		 * static settings
		 */
		$this->debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE );
		$this->dev   = $this->debug ? '' : '.min';
		$this->eol   = $this->debug ? PHP_EOL : '';
		$this->base  = dirname( dirname( __DIR__ ) );
		$this->dir   = basename( $this->base );
		$this->url   = plugins_url( $this->dir );
		/**
		 * plugin ID
		 */
		$this->plugin_file_path = $this->base . '/simple-consent-mode.php';
		$this->plugin_file      = plugin_basename( $this->plugin_file_path );
		/**
		 * WordPress Hooks
		 */
		add_action( 'init', array( $this, 'action_init' ) );
		/**
		 * Simple Consent Mode database log table
		 *
		 * @since 1.1.0
		 */
		global $wpdb;
		$wpdb->iworks_scm_log = $wpdb->prefix . 'iworks_scm_log';
	}

	public function action_init() {
		$this->check_option_object();
		$this->options->options_init();
	}

	public function get_version( $file = null ) {
		if ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE ) {
			if ( null != $file ) {
				$file = dirname( $this->base ) . $file;
				if ( is_file( $file ) ) {
					return md5_file( $file );
				}
			}
			return time();
		}
		return $this->version;
	}

	protected function get_meta_name( $name ) {
		return sprintf( '%s_%s', $this->meta_prefix, sanitize_title( $name ) );
	}

	public function get_post_type() {
		return $this->post_type;
	}

	public function get_capability() {
		return $this->capability;
	}

	private function slug_name( $name ) {
		return preg_replace( '/[_ ]+/', '-', strtolower( __CLASS__ . '_' . $name ) );
	}

	public function get_post_meta( $post_id, $meta_key ) {
		return get_post_meta( $post_id, $this->get_meta_name( $meta_key ), true );
	}

	protected function get_module_file( $filename, $vendor = 'iworks' ) {
		return realpath(
			sprintf(
				'%s/%s/%s/%s.php',
				$this->base,
				$vendor,
				$this->dir,
				$filename
			)
		);
	}

	protected function get_template_file_name( $slug, $name = null, $side = 'frontend' ) {
		$slug = sanitize_file_name( $slug );
		$name = sanitize_file_name( $name );
		$side = sanitize_file_name( $side );
		/**
		 * base
		 */
		$base = sprintf(
			'%s/%s/assets/templates/%s',
			WP_PLUGIN_DIR,
			$this->dir,
			$side
		);
		/**
		 * find file
		 */
		$patterns = array(
			'%1$s/%2$s/%3$s.php',
			'%1$s/%2$s-%3$s.php',
			'%1$s/%2$s/%3$s/index.php',
			'%1$s/%2$s-%3$s/index.php',
		);
		foreach ( $patterns as $pattern ) {
			$filename = sprintf( $pattern, $base, $slug, $name );
			if ( is_file( $filename ) ) {
				return realpath( $filename );
			}
		}
		/**
		 * no file
		 */
		return new WP_Error(
			'error',
			sprintf(
				/* translators: %1$s template site name, %2$s template slug, %3$s template name */
				esc_html__( 'Missing template file: %1$s/%2$s/%3$s.', 'simple-consent-mode' ),
				$side,
				$slug,
				$name
			)
		);
	}

	protected function html_title( $text ) {
		printf( '<h1 class="wp-heading-inline">%s</h1>', esc_html( $text ) );
	}

	/**
	 * check option object
	 *
	 * @since 1.0.0
	 */
	protected function check_option_object() {
		if ( is_a( $this->options, 'iworks_options' ) ) {
			return;
		}
		$this->options = iworks_simple_consent_mode_get_options();
	}

	/**
	 * get and check cookie value
	 *
	 * @since 1.2.0
	 */
	protected function check_and_prepare_user_consents( $cookie_value ) {
		if ( empty( $cookie_value ) ) {
			return array();
		}
		/**
		 * old log format
		 */
		switch ( $cookie_value ) {
			case 'deny':
				return array(
					'ad_personalization' => 'denied',
					'ad_storage'         => 'denied',
					'ad_user_data'       => 'denied',
					'analytics_storage'  => 'denied',
				);
			case 'all':
				return array(
					'ad_personalization' => 'granted',
					'ad_storage'         => 'granted',
					'ad_user_data'       => 'granted',
					'analytics_storage'  => 'granted',
				);
		}
		/**
		 * format
		 *
		 * @since 1.2.0
		 */
		$user_consents = array();
		if ( empty( $cookie_value ) ) {
			return $user_consents;
		}
		foreach ( explode( ',', $cookie_value ) as $one ) {
			$data = explode( ':', $one );
			if ( 1 < sizeof( $data ) ) {
				$user_consents[ $data[0] ] = $data[1];
			}
		}
		return $user_consents;
	}
}
