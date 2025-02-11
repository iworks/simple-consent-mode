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
	protected $version;
	protected $url;
	protected $plugin_file;

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

	public function __construct() {
		/**
		 * static settings
		 */
		$this->debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE );
		$this->dev   = $this->debug ? '' : '.min';
		$this->eol   = $this->debug ? PHP_EOL : '';
		$this->base  = dirname( dirname( __FILE__ ) );
		$this->dir   = basename( dirname( $this->base ) );
		$this->url   = plugins_url( $this->dir );
		/**
		 * plugin ID
		 */
		$this->plugin_file = plugin_basename( dirname( $this->base ) . '/simple-consent-mode.php' );
		/**
		 * WordPress Hooks
		 */
		add_action( 'init', array( $this, 'action_init' ) );
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}

	public function action_init() {
		$this->check_option_object();
		$this->options->options_init();
	}

	public function action_admin_init() {
		$this->check_option_object();
	}

	public function get_version( $file = null ) {
		if ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE ) {
			if ( null != $file ) {
				$file = dirname( $this->base ) . $file;
				if ( is_file( $file ) ) {
					return md5_file( $file );
				}
			}
			return rand( 0, PHP_INT_MAX );
		}
		return $this->version;
	}

	protected function get_meta_name( $name ) {
		return sprintf( '%s_%s', $this->meta_prefix, sanitize_title( $name ) );
	}

	public function get_post_type() {
		return $this->post_type;
	}

	public function get_this_capability() {
		return $this->capability;
	}

	private function slug_name( $name ) {
		return preg_replace( '/[_ ]+/', '-', strtolower( __CLASS__ . '_' . $name ) );
	}

	public function get_post_meta( $post_id, $meta_key ) {
		return get_post_meta( $post_id, $this->get_meta_name( $meta_key ), true );
	}

	protected function print_table_body( $post_id, $fields ) {
		echo '<table class="widefat striped"><tbody>';
		foreach ( $fields as $name => $data ) {
			$key   = $this->get_meta_name( $name );
			$value = $this->get_post_meta( $post_id, $name );
			/**
			 * extra
			 */
			$extra = isset( $data['placeholder'] ) ? sprintf( ' placeholder="%s" ', esc_attr( $data['placeholder'] ) ) : '';
			foreach ( array( 'placeholder', 'style', 'class', 'id' ) as $extra_key ) {
				if ( isset( $data[ $extra_key ] ) ) {
					$extra .= sprintf( ' min="%d" ', esc_attr( $data[ $extra_key ] ) );
				}
			}
			/**
			 * start row
			 */
			echo '<tr>';
			printf( '<th scope="row" style="width: 130px">%s</th>', $data['title'] );
			echo '<td>';
			switch ( $data['type'] ) {
				case 'number':
					foreach ( array( 'min', 'max', 'step' ) as $extra_key ) {
						if ( isset( $data[ $extra_key ] ) ) {
							$extra .= sprintf( ' min="%d" ', intval( $data[ $extra_key ] ) );
						}
					}
					printf(
						'<input type="number" name="%s" value="%d" %s />',
						esc_attr( $key ),
						intval( $value ),
						$extra
					);
					break;
				case 'date':
					$date = intval( $this->get_post_meta( $post_id, $name ) );
					if ( empty( $date ) ) {
						$date = strtotime( 'now' );
					}
					printf(
						'<input type="text" class="datepicker" name="%s" value="%s" />',
						$this->get_meta_name( $name ),
						$date
					);
					break;
			}
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
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
	private function check_option_object() {
		if ( is_a( $this->options, 'iworks_options' ) ) {
			return;
		}
		$this->options = get_iworks_simple_consent_mode_options();
	}
}
