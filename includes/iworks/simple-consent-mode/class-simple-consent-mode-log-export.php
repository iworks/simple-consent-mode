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

defined( 'ABSPATH' ) || exit; // Exit if accessed directly
/**
 * Export Orphans Configuration.
 *
 * The class allows to export plugin configuration to JSON file.
 *
 * @since 3.3.0
 */
class iWorks_Orphans_Export {
	private $options;

	public function __construct() {
		add_action( 'admin_print_scripts', array( $this, 'action_admin_print_scripts' ), PHP_INT_MAX );
	}

	/**
	 * add admin scripts
	 *
	 * @since 3.3.0
	 */
	public function action_admin_print_scripts() {
		echo PHP_EOL;
		?><script id="<?php echo esc_attr( __CLASS__ ); ?>">
jQuery(document).ready(function($) {
	$('input[name=iworks_orphan_export]').on( 'click', function(e) {
		e.preventDefault();
		$form = $('<form method="post"></form>');
		$form.append('<input type="hidden" name="nonce" value="'+$(this).data('nonce') +'">');
		$form.append('<input type="hidden" name="extra" value="'+$('input[name=iworks_orphan_export_extra]').is(':checked') +'">');
		$('body').append($form);
		$form.submit();
	});
});
</script>
		<?php
	}

	/**
	 * Prepare and send JSON file
	 *
	 * @since 3.3.0
	 */
	public function send_json() {
		$add_wordpress_data = 'true' === filter_input( INPUT_POST, 'extra' );
		/**
		 * data
		 */
		$data = array(
			'Meta'      => array(
				'date'   => date( 'c' ),
				'plugin' => array(
					'name'    => 'Orphans',
					'version' => 'PLUGIN_VERSION',
				),
				'url'    => array(
					'GitHub'    => 'https://github.com/iworks/sierotki',
					'WordPress' => 'https://wordpress.org/plugins/sierotki/',
				),
			),
			'Orphans'   => $this->get_settings_plugin(),
			'WordPress' => $add_wordpress_data ? $this->get_wordpress_settings() : array(),
		);
		/**
		 * filename
		 */
		$filename = sanitize_file_name(
			sprintf(
				'%s-%s.json',
				get_option( 'blogname' ),
				date( 'c' )
			)
		);
		/**
		 * export file
		 */
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/json' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Pragma: public' );
		echo json_encode( $data, JSON_PRETTY_PRINT );
		exit;
	}

	/**
	 * get plugin settings
	 *
	 * @since 3.3.0
	 */
	private function get_settings_plugin() {
		$this->options = get_orphan_options();
		$options       = $this->options->get_group();
		$data          = array();
		if (
			is_array( $options )
			&& isset( $options['options'] )
		) {
			foreach ( $options['options'] as $one ) {
				if ( ! isset( $one['name'] ) ) {
					continue;
				}
				$option_name = $this->options->get_option_name( $one['name'] );
				$data[]      = array(
					'name'         => $one['name'],
					'option_name'  => $this->options->get_option_name( $one['name'] ),
					'option_value' => $this->options->get_option( $one['name'] ),
				);
			}
		}
		return $data;
	}

	/**
	 * get WordPress settings
	 *
	 * @since 3.3.0
	 */
	private function get_wordpress_settings() {
		$fields = array(
			'siteurl',
			'blogname',
			'blog_charset',
			'WPLANG',
		);
		$data   = array();
		foreach ( $fields as $option_name ) {
			$data[ $option_name ] = get_option( $option_name );
		}
		/**
		 * plugins
		 */
		$data['Plugins'] = array();
		if ( apply_filters( 'iworks_orphans_export_plugins', true ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugins = get_option( 'active_plugins' );
			$fields  = array(
				'Name',
				'PluginURI',
				'Version',
			);
			if ( is_array( $plugins ) ) {
				foreach ( $plugins as $one ) {
					$plugin = get_plugin_data( WP_PLUGIN_DIR . '/' . $one );
					foreach ( $fields as $field_name ) {
						$data['Plugins'][ $plugin['Name'] ][ $field_name ] = $plugin[ $field_name ];
					}
				}
			}
		}
		/**
		 * theme
		 */
		$data['Theme'] = array();
		if ( apply_filters( 'iworks_orphans_export_theme', true ) ) {
			$theme  = wp_get_theme();
			$fields = array(
				'Name',
				'ThemeURI',
				'Description',
				'Version',
			);
			foreach ( $fields as $one ) {
				$data['Theme'][ $one ] = $theme->get( $one );
			}
		}
		return $data;
	}
}

