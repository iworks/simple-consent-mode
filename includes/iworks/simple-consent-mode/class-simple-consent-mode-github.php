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

if ( class_exists( 'iworks_simple_consent_mode_github' ) ) {
	return;
}

require_once( dirname( __FILE__ ) . '/class-simple-consent-mode-base.php' );

class iworks_simple_consent_mode_github extends iworks_simple_consent_mode_base {

	public function __construct() {
		parent::__construct();
		$this->version = 'PLUGIN_VERSION';
		/**
		 * WordPress Hooks
		 */
		add_action( 'init', array( $this, 'action_init_load_plugin_textdomain' ) );
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

