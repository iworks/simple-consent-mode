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

if ( class_exists( 'iworks_simple_consent_mode_wp_admin' ) ) {
	return;
}

require_once( dirname( __DIR__ ) . '/class-simple-consent-mode-base.php' );

class iworks_simple_consent_mode_wp_admin extends iworks_simple_consent_mode_base {
	public function __construct() {
		parent::__construct();
		/**
		 * WordPress Hooks
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts_register_assets' ), 0 );
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
		add_action( 'admin_init', array( $this, 'action_maybe_send_log' ), 0 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
	}

	public function action_admin_init() {
		$this->check_option_object();
		$this->options->options_init();
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
	 * register assets
	 *
	 * @since 1.1.0
	 */
	public function action_admin_enqueue_scripts_register_assets() {
		$name = $this->options->get_option_name( 'admin' );
		$file = '/assets/scripts/simple-consent-mode-admin' . $this->dev . '.js';
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
	 * maybe send log
	 *
	 * @since 1.1.0
	 */
	public function action_maybe_send_log() {
		/**
		 * file
		 */
		$file = sprintf(
			'%s-simple-consent-mode-log.csv',
			date( 'Y-m-d-h-i' )
		);
		if ( 'export' !== filter_input( INPUT_POST, 'export' ) ) {
			return;
		}
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, '_wpnonce' ), 'iw_scm_log_export' ) ) {
			return;
		}
		global $wpdb;
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename=' . $file );
		$out = fopen( 'php://output', 'w' );
		fputcsv( $out, $wpdb->get_col( "desc {$wpdb->iworks_scm_log}" ) );
		foreach ( $wpdb->get_results( "select * from {$wpdb->iworks_scm_log} order by 1", ARRAY_N ) as $row ) {
			fputcsv( $out, $row );
		}
		fclose( $out );
		exit;
	}
}

